<?php

namespace App\Http\Controllers\Admin;

use App\Addon;
use App\FreelancerOffer;
use App\FreelancerOfferDispute;
use App\Http\Controllers\actions\UtilitiesController;
use App\OfferCategory;
use App\OfferSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\DisputeNotification;
use App\Notification;
use App\ProjectManagerOffer;
use App\ProjectManagerOfferDispute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{
    public function addons(Request $request, $id = null)
    {
        try {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'title' => 'bail|required|string',
                    'description' => 'bail|required|string',
                    'amount' => 'bail|required',
                ]);

                $addon = new Addon();
                $addon->title = $request->title;
                $addon->description = $request->description;
                $addon->amount = $request->amount;
                $addon->save();

                return back()->with('success', 'Offer Addon has been added successfully');
            } elseif ($request->isMethod('put') && $id && $addon = Addon::find($id)) {
                $this->validate($request, [
                    'title' => 'bail|required|string',
                    'description' => 'bail|required|string',
                    'amount' => 'bail|required',
                ]);

                $addon->title = $request->title;
                $addon->description = $request->description;
                $addon->amount = $request->amount;
                $addon->save();

                return back()->with('success', 'Offer Addon has been modified successfully');
            }

            $addons = Addon::get();

            return view('admin.offers.addons.index', compact('addons'));
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function categories(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'title' => 'bail|required|string'
                ]);

                $slug = Str::slug($request->title);
                $slug_addition = 0;
                $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                while (OfferCategory::where('slug', $new_slug)->count() > 0) {
                    $slug_addition++;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                }

                $category = new OfferCategory();
                $category->title = $request->title;
                $category->slug = $new_slug;
                $category->save();

                return back()->with('success', 'Offer Category has been added successfully');
            }

            $categories = OfferCategory::get();

            return view('admin.offers.categories.index', compact('categories'));
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function showCategory($id)
    {
        try {
            if ($category = OfferCategory::find($id)) {
                return view('admin.offers.categories.show', compact('category'));
            }

            throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function subCategory(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                    'picture' => 'image|nullable|max:5999',
                ]);

                if ($category = OfferCategory::find($request->category_id)) {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                    while (OfferSubCategory::where('slug', $new_slug)->count() > 0) {
                        $slug_addition++;
                        $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                    }

                    $sub_category = new OfferSubCategory();
                    $sub_category->offer_category_id = $category->id;
                    $sub_category->title = $request->title;
                    $sub_category->slug = $new_slug;
                    $sub_category->base_amount = $request->base_amount;
                    if ($request->hasFile('picture')) {
                        $image = $request->file('picture');
                        $call = new UtilitiesController();
                        $fileNameToStore = $call->fileNameToStore($image);
                        $sub_category->picture = $fileNameToStore;
                    }
                    $sub_category->save();

                    return back()->with('success', 'Offer Category has been added successfully');
                }

                throw new \Exception("Invalid Category", 1);
            } else if ($request->isMethod('put')) {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                    'base_amount' => 'bail|required',
                    'picture' => 'image|nullable|max:5999',
                ]);

                if ($sub_category = OfferSubCategory::find($request->sub_category_id)) {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                    while (OfferSubCategory::where('slug', $new_slug)->count() > 0) {
                        $slug_addition++;
                        $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                    }

                    $sub_category->title = $request->title;
                    $sub_category->slug = $new_slug;
                    $sub_category->base_amount = $request->base_amount;
                    if ($request->hasFile('picture')) {
                        $image = $request->file('picture');
                        $call = new UtilitiesController();
                        $fileNameToStore = $call->fileNameToStore($image);
                        $sub_category->picture = $fileNameToStore;
                    }
                    $sub_category->save();

                    return back()->with('success', 'Offer Category has been modified successfully');
                }

                throw new \Exception("Invalid Sub Category", 1);
            } else if ($request->isMethod('delete')) {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required'
                ]);

                if ($sub_category = OfferSubCategory::find($request->sub_category_id)) {
                    $sub_category->delete();

                    return back()->with('success', 'Sub Category has been removed successfully');
                }

                throw new \Exception("Invalid Sub Category", 1);
            }

            throw new \Exception("Error occurred", 1);
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        try {
            if ($category = OfferCategory::find($id)) {
                $category->delete();

                return back()->with('success', 'Category deleted successfully');
            }

            throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function project_manager_offers(Request $request, $status = null){
        try {
            $all_offers = ProjectManagerOffer::get();
            if($request->status){
                $status = $request->status;
                $filtered_offers = $all_offers->filter(function($item) use ($status){
                    return $item->status == $status;
                });
                $offers = $filtered_offers->all();
            }else{
                $offers = $all_offers;
            }
            // $offers = ProjectManagerOffer::paginate(10);
            // dd($offers);
            return view('admin.offers.project-manager', compact('offers', 'status'));

            // throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function freelancer_offers(Request $request, $status = null){
        try {
            // if($request->status){
            //     $status = $request->status;
            // }
            // $offers = FreelancerOffer::paginate(10);

            $all_offers = FreelancerOffer::get();
            if($request->status){
                $status = $request->status;
                $filtered_offers = $all_offers->filter(function($item) use ($status){
                    return $item->status == $status;
                });
                $offers = $filtered_offers->all();
            }else{
                $offers = $all_offers;
            }

            return view('admin.offers.freelancer', compact('offers', 'status'));

            // throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function hold_project_manager_offer(Request $request){
        try {
            $this->validate($request, [
                'offer' => 'bail|required|string',
            ]);
            $dispute = ProjectManagerOfferDispute::where('project_manager_offer_id', $request->offer)->first();
            if($dispute ==  null){
                $dispute = new ProjectManagerOfferDispute();
                $dispute->project_manager_offer_id = $request->project_manager_offer;
                $dispute->comments = $request->comments;
                $dispute->save();

                $offer = ProjectManagerOffer::find($request->offer);

                $notification = new Notification();
                $notification->project_manager_offer_dispute_id = $dispute->id;
                $notification->user_id = $offer->user_id;
                $notification->message = "A dispute has just been created for your project " . $dispute->project_manager_offer->title . " by " . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->project_manager_offer->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'project_manager_offer', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }
            } elseif($dispute != null && $dispute->resolved == true){
                $dispute->resolved = false;
                $dispute->comments = $request->comments ? $request->comments : $dispute->comments;
                $dispute->save();

                $offer = ProjectManagerOffer::find($request->offer);

                $notification = new Notification();
                $notification->project_manager_offer_dispute_id = $dispute->id;
                $notification->user_id = $offer->user_id;
                $notification->message = "A dispute has just been created for your project " . $dispute->project_manager_offer->title . " by " . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->project_manager_offer->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'project_manager_offer', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }
            }
            else{
                return back()->with('danger', 'This Offer is already on hold');
            }

            return back()->with('success', 'Offer Put on Hold');

            // throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function resolve_project_manager_offer($offer){
        try {
            //code...
            $dispute = ProjectManagerOfferDispute::where('project_manager_offer_id', $offer)->first();
            if($dispute ==  null){
                return back()->with('danger', 'This offer is not on hold');
            }else{
                $dispute->resolved = true;
                $dispute->save();
                return back()->with('success', 'This offer is already resolved');
            }
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function hold_freelancer_offer(Request $request){
        try {
            $this->validate($request, [
                'offer' => 'bail|required|string',
            ]);
            $dispute = FreelancerOfferDispute::where('freelancer_offer_id', $request->offer)->first();
            if($dispute ==  null){
                $dispute = new FreelancerOfferDispute();
                $dispute->freelancer_offer_id = $request->freelancer_offer;
                $dispute->comments = $request->comments;
                $dispute->save();

                $offer = FreelancerOffer::find($request->offer);

                $notification = new Notification();
                $notification->freelancer_offer_dispute_id = $dispute->id;
                $notification->user_id = $offer->user_id;
                $notification->message = "A dispute has just been created for your project " . $dispute->freelancer_offer->title . " by " . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->freelancer_offer->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'freelancer_offer', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }

            } elseif($dispute != null && $dispute->resolved == true){
                $dispute->resolved = false;
                $dispute->comments = $request->comments ? $request->comments : $dispute->comments;
                $dispute->save();

                $offer = FreelancerOffer::find($request->offer);

                $notification = new Notification();
                $notification->freelancer_offer_dispute_id = $dispute->id;
                $notification->user_id = $offer->user_id;
                $notification->message = "A dispute has just been created for your project " . $dispute->freelancer_offer->title . " by " . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->freelancer_offer->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'freelancer_offer', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }

            }
            else{
                return back()->with('danger', 'This Offer is already on hold');
            }

            return back()->with('success', 'Offer Put on Hold');

            // throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function resolve_freelancer_offer($offer){
        try {
            //code...
            $dispute = FreelancerOfferDispute::where('freelancer_offer_id', $offer)->first();
            if($dispute ==  null){
                return back()->with('danger', 'This offer is not on hold');
            } else{
                $dispute->resolved = true;
                $dispute->save();
                return back()->with('success', 'This offer is already resolved');
            }
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }
}