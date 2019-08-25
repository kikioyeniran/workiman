<?php

namespace App\Http\Controllers\Account;

use App\Addon;
use App\Contest;
use App\ContestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                'tags' => 'bail|required',
                'addons' => 'bail|required'
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
            } else {
                session('new_contest_id', $contest->id);
            }

            // Save contest
            $contest->save();

            return response()->json([
                'message' => 'Contest created successfully',
                'user_exists' => !is_null($contest->user_id)
            ]);

        } catch(ValidationException $exception)
        {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'status' => false
            ], 500);
        } catch(\Exception $exception)
        {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false
            ], 500);
        }
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
