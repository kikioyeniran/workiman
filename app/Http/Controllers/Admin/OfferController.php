<?php

namespace App\Http\Controllers\Admin;

use App\Addon;
use App\OfferCategory;
use App\OfferSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                    $sub_category->save();

                    return back()->with('success', 'Offer Category has been added successfully');
                }

                throw new \Exception("Invalid Category", 1);
            } else if ($request->isMethod('put')) {
                $this->validate($request, [
                    'sub_category_id' => 'bail|required',
                    'title' => 'bail|required|string',
                    'base_amount' => 'bail|required',
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
}
