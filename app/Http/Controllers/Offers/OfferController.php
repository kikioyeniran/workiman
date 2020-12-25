<?php

namespace App\Http\Controllers\Offers;

use App\Addon;
use App\FreelancerOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfferCategory;
use App\ProjectManagerOffer;
use App\ProjectManagerOfferFile;
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
            $offers = ProjectManagerOffer::orderBy('created_at', 'desc');
            $categories = OfferCategory::all();
            $filter_categories = [];
            $filter_keywords = [];

            if ($request->has("keyword")) {
                // $keyword = $request->keyword;
                $filter_keywords = explode(",", $request->keyword);
                Log::info($filter_keywords);
                foreach ($filter_keywords as $key => $keyword) {
                    if ($key == 0) {
                        $offers = $offers->where("title", "LIKE", "%" . $keyword . "%");
                    } else {
                        $offers = $offers->orWhere("title", "LIKE", "%" . $keyword . "%");
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

            $path = $this->getPath($request, "offers.project-managers.index");
            $offers = $offers->paginate(10)->setPath($path);

            return view('offers.project-manager.index', compact('offers', 'categories', 'filter_categories', 'filter_keywords'));
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

    public function projectManagerOffer(ProjectManagerOffer $offer)
    {
        return view('offers.project-manager.show', compact('offer'));
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
                        $offers = $offers->where("title", "LIKE", "%" . $keyword . "%");
                    } else {
                        $offers = $offers->orWhere("title", "LIKE", "%" . $keyword . "%");
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

    public function freelancerOffer(FreelancerOffer $offer)
    {
        return view('offers.freelancer.show', compact('offer'));
    }

    public function userOffers(Request $request, $username)
    {
        $page_number = $request->has('page') ? intval($request->page) : 1;
        $per_page = 2;
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

            $offers = array_splice($offers, $page_start, $per_page);

            return view('offers.user', compact('user', 'offers', 'page_number', 'total_pages'));
        }

        abort(404, "Invalid User");
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
                            'message' => 'Contest created successfully',
                            'user_exists' => !is_null($project_manager_offer->user_id),
                            'offer_id' => $project_manager_offer->id
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
                'message' => 'Contest files added successfully',
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
}
