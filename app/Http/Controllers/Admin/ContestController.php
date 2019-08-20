<?php

namespace App\Http\Controllers\Admin;

use App\ContestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ContestController extends Controller
{
    public function categories(Request $request)
    {
        try {

            if($request->isMethod('post'))
            {
                $this->validate($request, [
                    'title' => 'bail|required|string'
                ]);

                $slug = Str::slug($request->title);
                $slug_addition = 0;
                $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');

                while (ContestCategory::where('slug', $new_slug)->count() > 0){
                    $slug_addition++;
                    $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');
                }

                $category = new ContestCategory();
                $category->title = $request->title;
                $category->slug = $new_slug;
                $category->save();

                return back()->with('success', 'Contest Category has been added successfully');
            }

            $categories = ContestCategory::get();

            return view('admin.contests.categories.index', compact('categories'));

        } catch(ValidationException $exception)
        {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception)
        {
            return back()->with('danger', $exception->getMessage());
        }
    }

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
