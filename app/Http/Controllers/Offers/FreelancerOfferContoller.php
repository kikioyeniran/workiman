<?php

namespace App\Http\Controllers\Offers;

use App\FreelancerOffer;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerOfferContoller extends Controller
{
    public function disable(FreelancerOffer $offer)
    {
        try {
            //code...
            $offer->disabled = true;
            $offer->save();
            return redirect()->back()->with('success', "Freelancer Offer Hidden");
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function restore(FreelancerOffer $offer)
    {
        try {
            //code...
            $offer->disabled = false;
            $offer->save();
            return redirect()->back()->with('success', "Freelancer Offer Restored");
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function disabled()
    {
        try {
            //code...
            $user = auth()->user();
            $offers = FreelancerOffer::where('user_id', $user->id)->where('disabled', true)->get();
            return view('offers.freelancer.disabled', compact('offers'));
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }
}
