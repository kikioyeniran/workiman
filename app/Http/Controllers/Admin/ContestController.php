<?php

namespace App\Http\Controllers\Admin;

use App\ContestCategory;
use App\ContestSubCategory;
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

    public function showCategory($id)
    {
        try {
            if($category = ContestCategory::find($id))
            {
                return view('admin.contests.categories.show', compact('category'));
            }

            throw new \Exception("Invalid Category", 1);

        } catch (\Exception $exception)
        {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function subCategory(Request $request)
    {
        try {
            if($request->isMethod('post'))
            {
                $this->validate($request, [
                    'category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                ]);

                if($category = ContestCategory::find($request->category_id))
                {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');

                    while (ContestSubCategory::where('slug', $new_slug)->count() > 0){
                        $slug_addition++;
                        $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');
                    }

                    $sub_category = new ContestSubCategory();
                    $sub_category->contest_category_id = $category->id;
                    $sub_category->title = $request->title;
                    $sub_category->slug = $new_slug;
                    $sub_category->base_amount = $request->base_amount;
                    $sub_category->save();

                    return back()->with('success', 'Contest Category has been added successfully');
                }

                throw new \Exception("Invalid Category", 1);

            } else if($request->isMethod('put'))
            {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                    'base_amount' => 'bail|required',
                ]);

                if($sub_category = ContestSubCategory::find($request->sub_category_id))
                {
                    $slug = Str::slug($request->title);
                    $slug_addition = 0;
                    $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');

                    while (ContestSubCategory::where('slug', $new_slug)->count() > 0){
                        $slug_addition++;
                        $new_slug = $slug . ($slug_addition ? '-'.$slug_addition : '');
                    }

                    $sub_category->title = $request->title;
                    $sub_category->slug = $new_slug;
                    $sub_category->base_amount = $request->base_amount;
                    $sub_category->save();

                    return back()->with('success', 'Contest Category has been modified successfully');
                }

                throw new \Exception("Invalid Sub Category", 1);
            } else if($request->isMethod('delete'))
            {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required'
                ]);

                if($sub_category = ContestSubCategory::find($request->sub_category_id))
                {
                    $sub_category->delete();

                    return back()->with('success', 'Sub Category has been removed successfully');
                }

                throw new \Exception("Invalid Sub Category", 1);
            }

            throw new \Exception("Error occurred", 1);

        } catch(ValidationException $exception)
        {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception)
        {
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        try {
            if($category = ContestCategory::find($id))
            {
                $category->delete();

                return back()->with('success', 'Category deleted successfully');
            }

            throw new \Exception("Invalid Category", 1);

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
