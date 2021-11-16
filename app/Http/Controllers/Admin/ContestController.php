<?php

namespace App\Http\Controllers\Admin;

use App\Addon;
use App\Contest;
use App\ContestCategory;
use App\ContestDispute;
use App\ContestSubCategory;
use App\Http\Controllers\actions\UtilitiesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\DisputeNotification;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ContestController extends Controller
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

                return back()->with('success', 'Contest Addon has been added successfully');
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

                return back()->with('success', 'Contest Addon has been modified successfully');
            }

            $addons = Addon::get();

            return view('admin.contests.addons.index', compact('addons'));
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

                while (ContestCategory::where('slug', $new_slug)->count() > 0) {
                    $slug_addition++;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                }

                $category_icon_name = Str::random(5) . "." . $request->file('icon')->getClientOriginalExtension();
                Storage::putFileAs("public/category-icons", $request->file('icon'), $category_icon_name);

                $category = new ContestCategory();
                $category->title = $request->title;
                $category->icon = $category_icon_name;
                $category->slug = $new_slug;
                $category->save();

                return back()->with('success', 'Contest Category has been added successfully');
            }

            $categories = ContestCategory::get();

            return view('admin.contests.categories.index', compact('categories'));
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function showCategory($id)
    {
        try {
            if ($category = ContestCategory::find($id)) {
                return view('admin.contests.categories.show', compact('category'));
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
                    'picture' => 'image|nullable|max:5999'
                ]);

                if ($category = ContestCategory::find($request->category_id)) {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                    while (ContestSubCategory::where('slug', $new_slug)->count() > 0) {
                        $slug_addition++;
                        $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
                    }

                    $sub_category = new ContestSubCategory();
                    $sub_category->contest_category_id = $category->id;
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

                    return back()->with('success', 'Contest Category has been added successfully');
                }

                throw new \Exception("Invalid Category", 1);
            } else if ($request->isMethod('put')) {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                    'base_amount' => 'bail|required',
                    'picture' => 'image|nullable|max:5999'
                ]);

                if ($sub_category = ContestSubCategory::find($request->sub_category_id)) {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

                    while (ContestSubCategory::where('slug', $new_slug)->count() > 0) {
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

                    return back()->with('success', 'Contest Category has been modified successfully');
                }

                throw new \Exception("Invalid Sub Category", 1);
            } else if ($request->isMethod('delete')) {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required'
                ]);

                if ($sub_category = ContestSubCategory::find($request->sub_category_id)) {
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
            if ($category = ContestCategory::find($id)) {
                $category->delete();

                return back()->with('success', 'Category deleted successfully');
            }

            throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function hold_contest(Request $request){
        try {
            $this->validate($request, [
                'contest' => 'bail|required|string',
            ]);
            $dispute = ContestDispute::where('contest_id', $request->contest)->first();
            if($dispute ==  null){
                $dispute = new ContestDispute();
                $dispute->contest_id = $request->contest;
                $dispute->comments = $request->comments;
                $dispute->save();

                $contest = Contest::find($request->contest);

                $notification = new Notification();
                $notification->contest_dispute_id = $dispute->id;
                $notification->user_id = $contest->user_id;
                $notification->message = "A dispute has just been created for your project" . $dispute->contest->title . "by" . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->contest->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'contest', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }
            } elseif($dispute != null && $dispute->resolved == true){
                $dispute->resolved = false;
                $dispute->comments = $request->comments ? $request->comments : $dispute->comments;
                $dispute->save();

                $contest = Contest::find($request->contest);

                $notification = new Notification();
                $notification->contest_dispute_id = $dispute->id;
                $notification->user_id = $contest->user_id;
                $notification->message = "A dispute has just been created for your project " . $dispute->contest->title . " by " . auth()->user()->username;
                $notification->save();

                try {
                    $sender = auth()->user();
                    $reciever = $dispute->contest->user;
                    Mail::to($reciever->email)
                    ->cc($reciever->email)
                    ->bcc('kikioyeniran@gmail.com')
                    ->send(new DisputeNotification($dispute->id, 'contest', $sender->id, $reciever->id));
                    Log::alert("email sent sucessfully for to {$reciever->email}");

                } catch (\Throwable $th) {
                    Log::alert("email for new chat with to {$reciever->email} failed to send due to " . $th->getMessage());
                }
            }
            else{
                return back()->with('danger', 'This Contest is already on hold');
            }

            return back()->with('success', 'Contest Put on Hold');

            // throw new \Exception("Invalid Category", 1);
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function resolve_contest($contest){
        try {
            //code...
            $dispute = ContestDispute::where('contest_id', $contest)->first();
            if($dispute ==  null){
                return back()->with('danger', 'This Contest is not on hold');
            }else{
                $dispute->resolved = true;
                $dispute->save();
                return back()->with('success', 'This Contest is already resolved');
            }
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status = null)
    {
        try {
            if($request->status){
                $status = $request->status;
            }

            $all_contests = Contest::get();
            if($request->status){
                $status = $request->status;
                $filtered_contests = $all_contests->filter(function($item) use ($status){
                    return $item->status == $status;
                });
                $contests = $filtered_contests->all();
            }else{
                $contests = $all_contests;
            }

            $contest_user = Auth::user();
            // $contests = Contest::paginate(10);
            // dd($contests);

            return view('admin.contests.index', compact('contests', 'contest_user','status'));
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}