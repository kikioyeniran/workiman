<?php

namespace App\Http\Controllers\Offers;

use App\FreelancerOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfferCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{
    public function userOffers()
    {
        return 'You\'ll see this user\'s offers here soon';
        return view('');
    }

    public function new(Request $request)
    {
        $user = auth()->user();
        $categories = OfferCategory::get();

        if($request->isMethod('post'))
        {
            try {
                switch ($request->offer_type) {
                    case 'freelancer':
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

                        return back()->with('success', 'Your offer has been saved successfully');

                        break;
                    case 'project-manager':

                        break;
                }

            } catch (ValidationException $exception)
            {
                return back()->with('danger', $exception->validator->errors()->first());
            } catch (\Exception $exception)
            {
                return back()->with('danger', $exception->getMessage());
            }
        }

        if($user->freelancer) {
            // User is a freelancer so show freelancer offer form
            $view = 'offers.new.freelancer';
        } else {
            // // Show project manager offer form
            $view = 'offers.new.project-manager';
        }

        return view($view, compact('categories'));
    }
}
