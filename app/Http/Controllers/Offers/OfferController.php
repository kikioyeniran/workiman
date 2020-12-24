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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{
    public function projectManagerOffers($id = null)
    {
        // Fetch list of project manager offers
        if(!is_null($id) && $offer = ProjectManagerOffer::find($id))
        {
            // Get Offer with that ID

            return view('offers.show.project-manager', compact('offer'));
        }

        return view('offers');
    }

    public function freelancerOffers($id = null)
    {
        // Fetch list of project manager offers
        if(!is_null($id) && $offer = FreelancerOffer::find($id))
        {
            // Get Offer with that ID

            return view('offers.freelancer');
        }

        return view('offers');
    }

    public function userOffers(Request $request, $username)
    {
        $page_number = $request->has('page') ? intval($request->page) : 1;
        $per_page = 2;
        $page_start = ($page_number - 1) * $per_page;
        $total_pages = 1;

        if($user = User::where('username', $username)->first())
        {
            $offers = [];

            // Get freelancer offers
            $freelancer_offers = $user->freelancer_offers;
            // $freelancer_offers = FreelancerOffer::where('user_id', $user->id)->get();

            // Get PRoject Manager Offers
            $project_manager_offers = $user->project_manager_offers->where('offer_user_id', null);

            $offers = array_merge($freelancer_offers->toArray(), $project_manager_offers->toArray());

            usort($offers, function($a, $b)
            {
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

        if($request->isMethod('post'))
        {
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
                        $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');

                        while (FreelancerOffer::where('slug', $new_slug)->count() > 0){
                            $slug_addition++;
                            $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');
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

                    } catch (ValidationException $exception)
                    {
                        return back()->with('danger', $exception->validator->errors()->first());
                    } catch (\Exception $exception)
                    {
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
                        if(in_array(4, $request->addons))
                        {
                            $this->validate($request, [
                                'nda' => 'bail|required'
                            ]);
                        }

                        $budget = $request->budget;

                        // Create project_manager_offer
                        $project_manager_offer = new ProjectManagerOffer();

                        $project_manager_offer->sub_category_id = $request->category;
                        $project_manager_offer->title = $request->title;
                        $project_manager_offer->description = $request->description;
                        $project_manager_offer->minimum_designer_level = $request->designer_level;
                        $project_manager_offer->budget = $budget;
                        $project_manager_offer->delivery_mode = $request->delivery_mode;
                        $project_manager_offer->timeline = $request->timeline;

                        if($request->this_offer_type == "private")
                        {
                            $this->validate($request, [
                                'offer_user' => 'bail|required'
                            ]);

                            $project_manager_offer->offer_user_id = $request->offer_user;
                        }

                        // Check for signed in user and assign ownership to user
                        if(auth()->check())
                        {
                            $project_manager_offer->user_id = auth()->user()->id;
                        }

                        // Save project_manager_offer
                        $project_manager_offer->save();

                        // Add project_manager_offer tags
                        if($request->has('skills'))
                        {
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

                    } catch(ValidationException $exception)
                    {
                        return response()->json([
                            'message' => $exception->validator->errors()->first(),
                            'success' => false
                        ], 500);
                    } catch(\Exception $exception)
                    {
                        return response()->json([
                            'message' => $exception->getMessage(),
                            'success' => false
                        ], 500);
                    }
                    break;
            }
        }

        if($user->freelancer) {
            // User is a freelancer so show freelancer offer form
            $view = 'offers.new.freelancer';
        } else {
            // // Show project manager offer form
            $view = 'offers.new.project-manager';
        }

        return view($view, compact('categories', 'addons', 'users'));
    }

    public function images(Request $request)
    {
        try {
            $this->validate($request, [
                'offer_id' => 'bail|required'
            ]);

            foreach ($request->files as $offer_file) {
                $offer_file_name = str_random(10).'.'.$offer_file->getClientOriginalExtension();

                // Move to location
                Storage::putFileAs('public/offer-files/'.$request->offer_id, $offer_file, $offer_file_name);

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

        } catch(ValidationException $exception)
        {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch(\Exception $exception)
        {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }
}
