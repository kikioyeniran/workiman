<?php

namespace App\Http\Controllers\Contests;

use App\Contest;
use App\ContestCategory;
use App\ContestTag;
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
        // try {
        $contests = Contest::whereHas('payment')->orderBy('created_at', 'desc');
        $categories = ContestCategory::all();
        $filter_categories = [];
        $filter_keywords = [];
        $search_keyword = $request->keyword;
        // $contest_category = $request->contest_category;

        if ($request->has("keyword")) {
            // $keyword = $request->keyword;
            $filter_keywords = explode(",", $request->keyword);
            foreach ($filter_keywords as $key => $keyword) {
                if ($key == 0) {
                    $contests = $contests->where(function ($query) use ($keyword) {
                        $query->where("title", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhere("description", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhereHas('tags', function ($tags) use ($keyword) {
                                $tags->where("title", "LIKE", "%" . trim($keyword) . "%");
                            });
                    });
                } else {
                    $contests = $contests->orWhere(function ($query) use ($keyword) {
                        $query->where("title", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhere("description", "LIKE", "%" . trim($keyword) . "%")
                            ->orWhereHas('tags', function ($tags) use ($keyword) {
                                $tags->where("title", "LIKE", "%" . trim($keyword) . "%");
                            });
                    });
                }
            }
        }

        if ($request->has("category")) {
            // dd($request->category);
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

        if (auth()->check() && !auth()->user()->freelancer) {
            $contests = $contests->where('user_id', auth()->user()->id);
        }

        $path = $this->getPath($request);
        // Remove expired contests
        // $contests = $contests->whereNull("ended_at")->whereNotNull("ends_at")->where("ends_at", ">", now());

        $tag_suggestions = [];

        foreach ($contests->get() as $contest) {
            foreach ($contest->tags as $tag) {
                if (!in_array(strtolower($tag->title), $tag_suggestions)) {
                    array_push($tag_suggestions, strtolower($tag->title));
                }
            }
        }

        $tags_not_used = ContestTag::whereHas('contest', function ($contest) {
            $contest->whereHas('payment');
        })->whereNotIn(strtolower('title'), $tag_suggestions)->inRandomOrder()->get();

        foreach ($tags_not_used as $unused_tag) {
            if (!in_array(strtolower($unused_tag->title), $tag_suggestions)) {
                array_push($tag_suggestions, strtolower($unused_tag->title));
            }
            if (count($tag_suggestions) >= 10) {
                break;
            }
        }

        shuffle($tag_suggestions);

        $contests = $contests->paginate(20)->setPath($path);

        $user_location_currency = getCurrencyFromLocation(config('app.test_currency_ip'));

        return view('contests.index', compact('contests', 'categories', 'filter_categories', 'filter_keywords', 'search_keyword', 'tag_suggestions', 'user_location_currency'));
        // } catch (\Throwable $th) {
        //     return redirect()->route("contests.index")->with("danger", $th->getMessage());
        // }
    }

    public function user(Request $request, $username)
    {
        try {
            if ($contest_user = User::where("username", $username)->first()) {
                $contests = Contest::where("user_id", $contest_user->id);

                if (auth()->check()) {
                    $contests = $contests->where(function ($query) {
                        $query->whereHas('payment')
                            ->orWhere('user_id', auth()->user()->id);
                    });
                } else {
                    $contests = $contests->where(function ($query) {
                        $query->whereHas('payment');
                    });
                }

                $contests = $contests->orderBy('created_at', 'desc')->paginate(10);

                $user_location_currency = getCurrencyFromLocation(config('app.test_currency_ip'));

                return view('contests.user', compact('contests', 'contest_user', 'user_location_currency'));
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

                $similar_contests = Contest::whereHas('payment')->orderBy('created_at', 'desc');

                $similar_contests = $similar_contests->whereHas('sub_category', function ($sub_category_query) use ($contest) {
                    $sub_category_query->where('contest_category_id', $contest->sub_category->contest_category_id);
                });

                if (auth()->check() && !auth()->user()->freelancer) {
                    $similar_contests = $similar_contests->where('user_id', auth()->user()->id);
                }

                $similar_contests = $similar_contests->where('id', '!=', $contest->id);

                // Remove expired contests
                // $similar_contests = $similar_contests->whereNull("ended_at")->whereNotNull("ends_at")->where("ends_at", ">", now());
                $similar_contests = $similar_contests->take(2)->get();

                $user_location_currency = getCurrencyFromLocation(config('app.test_currency_ip'));

                return view("contests.show", compact("contest", "similar_contests", "user_location_currency"));
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (\Throwable $th) {
            return redirect()->route("contests.index")->with("danger", $th->getMessage());
        }
    }
}