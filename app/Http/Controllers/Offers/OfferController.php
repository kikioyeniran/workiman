<?php

namespace App\Http\Controllers\Offers;

use App\Addon;
use App\FreelancerOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfferCategory;
use App\ProjectManagerOffer;
use App\ProjectManagerOfferComment;
use App\ProjectManagerOfferFile;
use App\ProjectManagerOfferInterest;
use App\ProjectManagerOfferPayment;
use App\ProjectManagerOfferSkill;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{
    public function getPath($request, $path = "offers.project-managers.index")
    {
        $filters = [];

        if ($request->has("keyword")) {
            $filters["keyword"] = gettype($request->keyword) == "array" ? implode(",", $request->keyword) : $request->keyword;
        }
        if ($request->has("category")) {
            $filters["category"] = gettype($request->category) == "array" ? implode(",", $request->category) : $request->category;
        }

        return route($path, $filters);
    }

    public function projectManagerOffers(Request $request)
    {
        try {
            $offers = ProjectManagerOffer::whereHas('payment')->orderBy('created_at', 'desc');
            $categories = OfferCategory::all();
            $filter_categories = [];
            $filter_keywords = [];
            $search_keyword = $request->keyword;

            if ($request->has("keyword")) {
                // $keyword = $request->keyword;
                $filter_keywords = explode(",", $request->keyword);
                Log::info($filter_keywords);
                foreach ($filter_keywords as $key => $keyword) {
                    if ($key == 0) {
                        $offers = $offers->where(function ($query) use ($keyword) {
                            $query->where("title", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhere("description", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhereHas('skills', function ($skills) use ($keyword) {
                                $skills->where("title", "LIKE", "%" . trim($keyword) . "%");
                            });
                        });
                    } else {
                        $offers = $offers->orWhere(function ($query) use ($keyword) {
                            $query->where("title", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhere("description", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhereHas('skills', function ($skills) use ($keyword) {
                                $skills->where("title", "LIKE", "%" . trim($keyword) . "%");
                            });
                        });
                    }
                }
            }

            if ($request->has("category")) {
                $filter_categories = explode(",", $request->category);
                $offers->where(function ($category_query) use ($filter_categories) {
                    foreach ($filter_categories as $category_key => $category_id) {
                        if (OfferCategory::find($category_id)) {
                            if ($category_key == 0) {
                                $category_query->whereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('offer_category_id', $category_id);
                                });
                            } else {
                                $category_query->orWhereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('offer_category_id', $category_id);
                                });
                            }
                        }
                    }
                });
            }

            $offers = $offers->where(function ($offer_query) {
                if (auth()->check()) {
                    $offer_query->where('offer_user_id', auth()->user()->id)->orWhereDoesntHave('offer_user')
                    ->where(function($query) {
                        $query->whereDoesntHave('interests', function ($interests) {
                            $interests->where('assigned', true);
                        })->orWherehas('interests', function ($interests) {
                                $interests->where('assigned', true)->where('user_id', auth()->user()->id);
                        });
                    })->orWhere('user_id', auth()->user()->id);
                    // $offer_query->whereHas('offer_user', function ($offer_user_query) {
                    //     $offer_user_query->where('id', auth()->user()->id);
                    // })->orWhereDoesntHave('offer_user');
                } else {
                    $offer_query->whereDoesntHave('offer_user')->whereDoesntHave('interests', function ($interests) {
                        $interests->where('assigned', true);
                    });
                }
            });

            // Remove offers that have already been assigned

            $path = $this->getPath($request, "offers.project-managers.index");
            $offers = $offers->paginate(10)->setPath($path);

            // dd($filter_categories);

            return view('offers.project-manager.index', compact('offers', 'categories', 'filter_categories', 'filter_keywords', 'search_keyword'));
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }

    public function projectManagerFilter(Request $request)
    {
        try {
            Log::info($request->all());

            $redirect_url = $this->getPath($request, "offers.project-managers.index");
            Log::info($redirect_url);

            return response()->json([
                "success" => true,
                "message" => "",
                "redirect_url" => $redirect_url
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function projectManagerOffer($offer_slug)
    {
        if ($offer = ProjectManagerOffer::whereHas('payment')->where('slug', $offer_slug)->first()) {
            $similar_offers = ProjectManagerOffer::whereHas('payment')->orderBy('created_at', 'desc');

            $similar_offers = $similar_offers->whereHas('sub_category', function ($sub_category_query) use ($offer) {
                $sub_category_query->where('offer_category_id', $offer->sub_category->offer_category_id);
            });

            if (auth()->check() && !auth()->user()->freelancer) {
                $similar_offers = $similar_offers->where('user_id', auth()->user()->id);
            }

            $similar_offers = $similar_offers->where('id', '!=', $offer->id);

            // Remove expired offers
            // $similar_offers = $similar_offers->whereNull("ended_at")->whereNotNull("ends_at")->where("ends_at", ">", now());
            $similar_offers = $similar_offers->take(2)->get();

            // dd($similar_offers);

            return view('offers.project-manager.show', compact('offer', 'similar_offers'));
        }
    }

    public function freelancerOffers(Request $request)
    {
        try {
            $offers = FreelancerOffer::orderBy('created_at', 'desc');
            $categories = OfferCategory::all();
            $filter_categories = [];
            $filter_keywords = [];

            if ($request->has("keyword")) {
                // $keyword = $request->keyword;
                $filter_keywords = explode(",", $request->keyword);
                Log::info($filter_keywords);
                foreach ($filter_keywords as $key => $keyword) {
                    if ($key == 0) {
                        $offers = $offers->where("title", "LIKE", "%" . trim($keyword) . "%");
                    } else {
                        $offers = $offers->orWhere("title", "LIKE", "%" . trim($keyword) . "%");
                    }
                }
            }

            if ($request->has("category")) {
                $filter_categories = explode(",", $request->category);
                $offers->where(function ($category_query) use ($filter_categories) {
                    foreach ($filter_categories as $category_key => $category_id) {
                        if (OfferCategory::find($category_id)) {
                            if ($category_key == 0) {
                                $category_query->whereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('offer_category_id', $category_id);
                                });
                            } else {
                                $category_query->orWhereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('offer_category_id', $category_id);
                                });
                            }
                        }
                    }
                });
            }

            $path = $this->getPath($request, "offers.freelancers.index");
            $offers = $offers->paginate(10)->setPath($path);

            return view('offers.freelancer.index', compact('offers', 'categories', 'filter_categories', 'filter_keywords'));
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }

    public function freelancerFilter(Request $request)
    {
        try {
            Log::info($request->all());

            $redirect_url = $this->getPath($request, "offers.freelancers.index");
            Log::info($redirect_url);

            return response()->json([
                "success" => true,
                "message" => "",
                "redirect_url" => $redirect_url
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function freelancerOffer($offer_slug)
    {
        if ($offer = FreelancerOffer::where('slug', $offer_slug)->first()) {
            return view('offers.freelancer.show', compact('offer'));
        }
    }

    public function userOffers(Request $request, $username)
    {
        $page_number = $request->has('page') ? intval($request->page) : 1;
        $per_page = 10;
        $page_start = ($page_number - 1) * $per_page;
        $total_pages = 1;

        if ($user = User::where('username', $username)->first()) {
            $offers = [];

            // Get freelancer offers
            $freelancer_offers = $user->freelancer_offers;
            // $freelancer_offers = FreelancerOffer::where('user_id', $user->id)->get();

            // Get PRoject Manager Offers
            $project_manager_offers = $user->project_manager_offers->where('offer_user_id', null);

            $offers = array_merge($freelancer_offers->toArray(), $project_manager_offers->toArray());

            usort($offers, function ($a, $b) {
                return $a['created_at'] <=> $b['created_at'];
            });

            $total_pages = ceil(count($offers) / $per_page);

            $offers = collect(array_splice($offers, $page_start, $per_page));

            // dd($offers);

            return view('offers.user', compact('user', 'offers', 'page_number', 'total_pages'));
        }

        abort(404, "Invalid User");
    }

    public function assignedOffers(Request $request, $username)
    {
        if ($user = User::where('username', $username)->first()) {
            # code...
            $offers = ProjectManagerOffer::whereHas('payment')->where(function($offers) use ($user) {
                $offers->where('offer_user_id', $user->id)
                ->orWHereHas('interests', function ($interests) use ($user) {
                    $interests->where('user_id', $user->id)->where('assigned', true);
                });
            })->get();

            // dd($offers);

            return view('offers.freelancer.assigned', compact('user', 'offers'));
        }

        abort(404);
    }

    public function new(Request $request)
    {
        $user = auth()->user();
        $categories = OfferCategory::get();
        $addons = Addon::get();
        $users = User::where('freelancer', true)->get();

        if ($request->isMethod('post')) {
            switch ($request->offer_type) {
                case 'freelancer':
                    try {
                        $this->validate($request, [
                            'title' => 'bail|required|string',
                            'category' => 'bail|required',
                            'description' => 'bail|required|string',
                            'price' => 'bail|required',
                        ]);

                        $slug = Str::slug($request->title);
                        $slug_addition = 0;
                        $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                        while (FreelancerOffer::where('slug', $new_slug)->count() > 0) {
                            $slug_addition++;
                            $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                        }

                        $freelancer_offer = new FreelancerOffer();
                        $freelancer_offer->title = $request->title;
                        $freelancer_offer->slug = $new_slug;
                        $freelancer_offer->sub_category_id = $request->category;
                        $freelancer_offer->description = $request->description;
                        $freelancer_offer->price = $request->price;
                        $freelancer_offer->user_id = auth()->user()->id;

                        $freelancer_offer->save();

                        return redirect()->route('offers.freelancers', ['id' => $freelancer_offer->id]);

                        return back()->with('success', 'Your offer has been saved successfully');
                    } catch (ValidationException $exception) {
                        return back()->with('danger', $exception->validator->errors()->first());
                    } catch (\Exception $exception) {
                        return back()->with('danger', $exception->getMessage());
                    }

                    break;
                case 'project-manager':

                    try {
                        $this->validate($request, [
                            'title' => 'bail|required|string',
                            'category' => 'bail|required',
                            'description' => 'bail|required|string',
                            'designer_level' => 'bail|required',
                            // 'possible_winners' => 'bail|required',
                            'budget' => 'bail|required',
                            'delivery_mode' => 'bail|required',
                            // 'nda' => 'bail|required',
                            'this_offer_type' => 'bail|required',
                            // 'offer_user' => 'bail|required',
                            // 'skills' => 'bail|required',
                            'timeline' => 'bail|required',
                            // 'addons' => 'bail|required'
                        ]);

                        // Check if nda addon was selected
                        if (in_array(4, $request->addons)) {
                            $this->validate($request, [
                                'nda' => 'bail|required'
                            ]);
                        }

                        $slug = Str::slug($request->title);
                        $slug_addition = 0;
                        $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                        while (FreelancerOffer::where('slug', $new_slug)->count() > 0) {
                            $slug_addition++;
                            $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                        }

                        $budget = $request->budget;

                        // Create project_manager_offer
                        $project_manager_offer = new ProjectManagerOffer();

                        $project_manager_offer->sub_category_id = $request->category;
                        $project_manager_offer->title = $request->title;
                        $project_manager_offer->slug = $new_slug;
                        $project_manager_offer->description = $request->description;
                        $project_manager_offer->minimum_designer_level = $request->designer_level;
                        $project_manager_offer->budget = $budget;
                        $project_manager_offer->delivery_mode = $request->delivery_mode;
                        $project_manager_offer->timeline = $request->timeline;

                        if ($request->this_offer_type == "private") {
                            $this->validate($request, [
                                'offer_user' => 'bail|required'
                            ]);

                            $project_manager_offer->offer_user_id = $request->offer_user;
                        }

                        // Check for signed in user and assign ownership to user
                        if (auth()->check()) {
                            $project_manager_offer->user_id = auth()->user()->id;
                        }

                        // Save project_manager_offer
                        $project_manager_offer->save();

                        // Add project_manager_offer tags
                        if ($request->has('skills')) {
                            foreach ($request->skills as $skill) {
                                $project_manager_offer_skill = new ProjectManagerOfferSkill();
                                $project_manager_offer_skill->project_manager_offer_id = $project_manager_offer->id;
                                $project_manager_offer_skill->title = $skill;
                                $project_manager_offer_skill->save();
                            }
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'Offer created successfully',
                            'user_exists' => !is_null($project_manager_offer->user_id),
                            'offer_id' => $project_manager_offer->id,
                            'offer_slug' => $project_manager_offer->slug,
                        ]);
                    } catch (ValidationException $exception) {
                        return response()->json([
                            'message' => $exception->validator->errors()->first(),
                            'success' => false
                        ], 500);
                    } catch (\Exception $exception) {
                        return response()->json([
                            'message' => $exception->getMessage(),
                            'success' => false
                        ], 500);
                    }
                    break;
            }
        }

        return view(("offers." . ($user->freelancer ? "freelancer" : "project-manager") . ".create"), compact('categories', 'addons', 'users'));
    }

    public function images(Request $request)
    {
        try {
            $this->validate($request, [
                'offer_id' => 'bail|required'
            ]);

            foreach ($request->files as $offer_file) {
                $offer_file_name = Str::random(10) . '.' . $offer_file->getClientOriginalExtension();

                // Move to location
                Storage::putFileAs('public/offer-files/' . $request->offer_id, $offer_file, $offer_file_name);

                $offer_file = new ProjectManagerOfferFile();
                $offer_file->project_manager_offer_id = $request->offer_id;
                $offer_file->content = $offer_file_name;
                $offer_file->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer files added successfully',
                // 'user_exists' => !is_null($offer->user_id),
                // 'offer_id' => $offer->id
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function payment(Request $request, ProjectManagerOffer $offer)
    {
        if ($request->isMethod('post')) {
            // TODO: Verify Payment

            // Save payment
            $project_manager_offer_payment = new ProjectManagerOfferPayment();
            $project_manager_offer_payment->project_manager_offer_id = $offer->id;
            $project_manager_offer_payment->amount = $request->amount;
            $project_manager_offer_payment->payment_reference = $request->payment_reference;
            $project_manager_offer_payment->payment_method = $request->payment_method;
            $project_manager_offer_payment->paid = true;
            $project_manager_offer_payment->save();

            // $offer->ends_at = now()->addDays($offer->duration);
            // $offer->save();

            return response()->json([
                'message' => 'Payment Saved successfully',
                'success' => true
            ]);
        }

        $user = auth()->check() ? auth()->user() : null;

        return view('offers.project-manager.payment', compact('offer', 'user'));
    }

    public function interestedFreelancers(Request $request, $offer_slug)
    {
        if ($offer = ProjectManagerOffer::where('slug', $offer_slug)->first()) {
            $user = auth()->check() ? auth()->user() : null;

            $interests = $offer->interests;

            return view('offers.project-manager.interested-freelancers', compact('offer', 'user', 'interests'));
        }

        abort(404);
    }

    public function interest(Request $request, ProjectManagerOffer $offer)
    {
        try {
            $this->validate($request, [
                'price' => 'bail|required|numeric',
                'timeline' => 'bail|required|numeric',
            ]);

            $user = auth()->user();

            if (ProjectManagerOfferInterest::where('user_id', $user->id)->where('project_manager_offer_id', $offer->id)->count() < 1) {
                $interest = new ProjectManagerOfferInterest();
                $interest->user_id = $user->id;
                $interest->price = $request->price;
                $interest->timeline = $request->timeline;
                $interest->project_manager_offer_id = $offer->id;
                $interest->save();
            }

            return response()->json([
                'message' => 'Interest saved successfully',
                'success' => true
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function comment(Request $request, ProjectManagerOffer $offer)
    {
        try {

            $user = auth()->user();

            $comment = new ProjectManagerOfferComment();
            $comment->user_id = $user->id;
            $comment->project_manager_offer_id = $offer->id;

            if ($request->hasFile('files')) {
                $files = [];
                foreach ($request->file('files') as $submission_file) {
                    $file_name = Str::random(10) . '.' . $submission_file->getClientOriginalExtension();

                    // Move to location
                    Storage::putFileAs('public/offer-comment-files/' . $offer->id, $submission_file, $file_name);
                    array_push($files, $file_name);
                }
                $comment->content = json_encode($files);
                $comment->content_type = 'file';
            } else {
                $this->validate($request, [
                    'comment' => 'bail|required|string',
                ]);
                $comment->content = $request->comment;
            }

            $comment->save();

            return response()->json([
                'message' => 'Comment saved successfully',
                'success' => true
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function assignFreelancer(Request $request, ProjectManagerOffer $offer)
    {
        try {
            $this->validate($request, [
                'interest' => 'bail|required|exists:project_manager_offer_interests,id',
            ]);

            $user = auth()->user();

            // Check that the offer has not been assigned already
            if ($offer->interests->where('assigned', true)->count() > 0) {
                throw new \Exception("This offer has already been assigned to a freelancer.", 1);
            }
            if (!$interest = $offer->interests->find($request->interest)) {
                throw new \Exception("Invalid interest.", 1);
            }

            $interest->assigned = true;
            $interest->save();

            return response()->json([
                'message' => 'Project manager assigned successfully',
                'success' => true
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }
}
