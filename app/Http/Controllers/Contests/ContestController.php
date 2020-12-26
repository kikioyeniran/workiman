<?php

namespace App\Http\Controllers\Contests;

use App\Contest;
use App\ContestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        try {
            $contests = Contest::whereHas('payment')->orderBy('created_at', 'desc');
            $categories = ContestCategory::all();
            $filter_categories = [];
            $filter_keywords = [];

            if ($request->has("keyword")) {
                // $keyword = $request->keyword;
                $filter_keywords = explode(",", $request->keyword);
                foreach ($filter_keywords as $key => $keyword) {
                    if ($key == 0) {
                        $contests = $contests->where("title", "LIKE", "%" . trim($keyword) . "%");
                    } else {
                        $contests = $contests->orWhere("title", "LIKE", "%" . trim($keyword) . "%");
                    }
                }
            }

            if ($request->has("category")) {
                $filter_categories = explode(",", $request->category);
                $contests->where(function ($category_query) use ($filter_categories) {
                    foreach ($filter_categories as $category_key => $category_id) {
                        if (ContestCategory::find($category_id)) {
                            if ($category_key == 0) {
                                $category_query->whereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('contest_category_id', $category_id);
                                });
                            } else {
                                $category_query->orWhereHas('sub_category', function ($sub_category_query) use ($category_id) {
                                    $sub_category_query->where('contest_category_id', $category_id);
                                });
                            }
                        }
                    }
                });
            }

            $path = $this->getPath($request);
            // Remove expired contests
            // $contests = $contests->whereNotNull("ends_at")->where("ends_at", ">", now());
            $contests = $contests->paginate(10)->setPath($path);

            return view('contests.index', compact('contests', 'categories', 'filter_categories', 'filter_keywords'));
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }

    public function user(Request $request, $username)
    {
        try {
            if ($contest_user = User::where("username", $username)->first()) {
                $contests = Contest::where("user_id", $contest_user->id)->whereHas('payment')->orderBy('created_at', 'desc')->paginate(10);

                return view('contests.user', compact('contests', 'contest_user'));
            }

            throw new \Exception("Invalid User", 1);
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }

    public function getPath($request)
    {
        $filters = [];

        if ($request->has("keyword")) {
            $filters["keyword"] = gettype($request->keyword) == "array" ? implode(",", $request->keyword) : $request->keyword;
        }
        if ($request->has("category")) {
            $filters["category"] = gettype($request->category) == "array" ? implode(",", $request->category) : $request->category;
        }

        return route("contests.index", $filters);
    }

    public function filter(Request $request)
    {
        try {
            Log::info($request->all());

            $redirect_url = $this->getPath($request);
            Log::info($redirect_url);

            return response()->json([
                "success" => true,
                "message" => "",
                "redirect_url" => $redirect_url
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function show($contest_slug)
    {
        try {
            if ($contest = Contest::where('slug', $contest_slug)->first()) {

                return view("contests.show", compact("contest"));
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }
}
