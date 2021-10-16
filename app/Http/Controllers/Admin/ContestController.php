<?php

namespace App\Http\Controllers\Admin;

use App\Addon;
use App\Contest;
use App\ContestCategory;
use App\ContestSubCategory;
use App\Http\Controllers\actions\UtilitiesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            // if ($request->isMethod('post')) {
            //     $this->validate($request, [
            //         'title' => 'bail|required|string'
            //     ]);

            //     $slug = Str::slug($request->title);
            //     $slug_addition = 0;
            //     $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

            //     while (ContestCategory::where('slug', $new_slug)->count() > 0) {
            //         $slug_addition++;
            //         $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
            //     }

            //     $category_icon_name = Str::random(5) . "." . $request->file('icon')->getClientOriginalExtension();
            //     Storage::putFileAs("public/category-icons", $request->file('icon'), $category_icon_name);

            //     $category = new ContestCategory();
            //     $category->title = $request->title;
            //     $category->icon = $category_icon_name;
            //     $category->slug = $new_slug;
            //     $category->save();

            //     return back()->with('success', 'Contest Category has been added successfully');
            // }

            $contest_user = Auth::user();
            $contests = Contest::paginate(10);
            // dd($contests);

            return view('admin.contests.index', compact('contests', 'contest_user'));
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