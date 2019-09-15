<?php

namespace App\Http\Controllers\Account;

use App\Addon;
use App\Contest;
use App\ContestCategory;
use App\ContestFile;
use App\ContestPayment;
use App\ContestTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ContestCategory::get();
        $addons = Addon::get();

        return view('contests.create', compact('categories', 'addons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'bail|required|string',
                'category' => 'bail|required',
                'description' => 'bail|required|string',
                'designer_level' => 'bail|required',
                'possible_winners' => 'bail|required',
                'budget' => 'bail|required',
                // 'tags' => 'bail|required',
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

            // Create contest
            $contest = new Contest();
            $contest->title = $request->title;
            $contest->sub_category_id = $request->category;
            $contest->description = $request->description;
            $contest->minimum_designer_level = $request->designer_level;
            $contest->budget = $budget;

            // Set prize money
            switch($request->possible_winners)
            {
                case 3:
                    $this->validate($request, [
                        'first_place_prize' => 'bail|required',
                        'second_place_prize' => 'bail|required',
                        'third_place_prize' => 'bail|required',
                    ]);
                    if(($request->first_place_prize + $request->second_place_prize + $request->third_place_prize) > $budget)
                    {
                        throw new \Exception("Your total prize money is above your budget", 1);
                    }
                    $contest->first_place_prize = $request->first_place_prize;
                    $contest->second_place_prize = $request->second_place_prize;
                    $contest->third_place_prize = $request->third_place_prize;
                break;
                case 2:
                    $this->validate($request, [
                        'first_place_prize' => 'bail|required',
                        'second_place_prize' => 'bail|required'
                    ]);
                    if(($request->first_place_prize + $request->second_place_prize) > $budget)
                    {
                        throw new \Exception("Your total prize money is above your budget", 1);
                    }
                    $contest->first_place_prize = $request->first_place_prize;
                    $contest->second_place_prize = $request->second_place_prize;
                break;
                default:
                    $contest->first_place_prize = $budget;
                break;
            }

            // Check for signed in user and assign ownership to user
            if(auth()->check())
            {
                $contest->user_id = auth()->user()->id;
            }

            // Save contest
            $contest->save();

            // Add contest tags
            if($request->has('tags'))
            {
                foreach ($request->tags as $tag) {
                    $contest_tag = new ContestTag();
                    $contest_tag->contest_id = $contest->id;
                    $contest_tag->title = $tag;
                    $contest_tag->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Contest created successfully',
                'user_exists' => !is_null($contest->user_id),
                'contest_id' => $contest->id
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

    public function images(Request $request)
    {
        try {
            $this->validate($request, [
                'contest_id' => 'bail|required'
            ]);

            foreach ($request->files as $contest_file) {
                $contest_file_name = str_random(10).'.'.$contest_file->getClientOriginalExtension();

                // Move to location
                Storage::putFileAs('public/contest-files/'.$request->contest_id, $contest_file, $contest_file_name);

                $contest_file = new ContestFile();
                $contest_file->contest_id = $request->contest_id;
                $contest_file->content = $contest_file_name;
                $contest_file->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Contest files added successfully',
                // 'user_exists' => !is_null($contest->user_id),
                // 'contest_id' => $contest->id
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

    public function payment(Request $request, $id)
    {
        if($contest = Contest::find($id))
        {
            if($request->isMethod('post'))
            {
                // TODO: Verify Payment

                // Save payment
                $contest_payment = new ContestPayment();
                $contest_payment->contest_id = $contest->id;
                $contest_payment->amount = $request->amount;
                $contest_payment->payment_reference = $request->payment_reference;
                $contest_payment->payment_method = $request->payment_method;
                $contest_payment->paid = true;
                $contest_payment->save();

                return response()->json([
                    'message' => 'Payment Saved successfully',
                    'success' => true
                ]);
            }

            $user = auth()->check() ? auth()->user() : null;

            return view('contests.payment', compact('contest', 'user'));
        }

        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'Invalist Contest',
                'success' => false
            ], 500);
        }

        dd('as');

        return redirect()->route('contests.create')->with('danger', 'Please create a contest first');
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
