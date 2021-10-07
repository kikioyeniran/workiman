<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Str;
use App\Addon;
use App\Contest;
use App\ContestAddon;
use App\ContestCategory;
use App\ContestFile;
use App\ContestPayment;
use App\ContestSubmission;
use App\ContestSubmissionComment;
use App\ContestSubmissionFile;
use App\ContestSubmissionFileComment;
use App\ContestTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewContestSubmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
// use ZanySoft\Zip\Zip;
use Zip;

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

    public function entries()
    {
        $user = auth()->user();

        $entries = $user->contest_submissions;

        // dd($user->id);

        $contest_entries = Contest::whereHas('submissions', function ($submissions) use ($user) {
            $submissions->where('user_id', $user->id);
        })->get();

        // dd($entries);
        $user_location_currency = getCurrencyFromLocation();

        return view('contests.entries', compact('entries', 'contest_entries', 'user', 'user_location_currency'));
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
            Log::info($request->all());
            $this->validate($request, [
                'title' => 'bail|required|string',
                'category' => 'bail|required',
                'description' => 'bail|required|string',
                'designer_level' => 'bail|required',
                'possible_winners' => 'bail|required',
                'budget' => 'bail|required',
                'currency' => 'bail|required',
                'duration' => "bail|required|numeric|between:3,7",
                // 'tags' => 'bail|required',
                // 'addons' => 'bail|required'
            ], [
                'duration.between' => 'The duration must be between :min to :max days'
            ]);

            // Check if nda addon was selected
            if (in_array(4, $request->addons)) {
                $this->validate($request, [
                    'nda' => 'bail|required'
                ]);
            }

            $budget = $request->budget;

            $slug = Str::slug($request->title);
            $slug_addition = 0;
            $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');

            while (Contest::where('slug', $new_slug)->count() > 0) {
                $slug_addition++;
                $new_slug = $slug . ($slug_addition ? '-' . $slug_addition : '');
            }

            // dd($slug);

            // Create contest
            $contest = new Contest();
            $contest->title = $request->title;
            $contest->slug = $new_slug;
            $contest->sub_category_id = $request->category;
            $contest->description = $request->description;
            $contest->minimum_designer_level = $request->designer_level;
            $contest->budget = $budget;
            $contest->currency = $request->currency;

            // Set prize money
            switch ($request->possible_winners) {
                case 3:
                    $this->validate($request, [
                        'first_place_prize' => 'bail|required|numeric|min:.1',
                        'second_place_prize' => 'bail|required|numeric|min:.1',
                        'third_place_prize' => 'bail|required|numeric|min:.1',
                    ]);
                    if (($request->first_place_prize + $request->second_place_prize + $request->third_place_prize) > 100) {
                        throw new \Exception("Your total prize money is above 100%", 1);
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
                    if (($request->first_place_prize + $request->second_place_prize) > 100) {
                        throw new \Exception("Your total prize money is above 100%", 1);
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
            if (auth()->check()) {
                $contest->user_id = auth()->user()->id;
            }

            // Save end date
            $contest->duration = $request->duration;

            // Save contest
            $contest->save();

            // Add contest tags
            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $contest_tag = new ContestTag();
                    $contest_tag->contest_id = $contest->id;
                    $contest_tag->title = $tag;
                    $contest_tag->save();
                }
            }

            // Add contest addons
            if ($request->has('addons')) {
                foreach ($request->addons as $addon) {
                    $contest_addon = new ContestAddon();
                    $contest_addon->contest_id = $contest->id;
                    $contest_addon->addon_id = $addon;
                    $contest_addon->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Contest created successfully',
                'user_exists' => !is_null($contest->user_id),
                'contest_id' => $contest->id
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

    public function images(Request $request)
    {
        try {
            $this->validate($request, [
                'contest_id' => 'bail|required'
            ]);

            foreach ($request->files as $contest_file) {
                $contest_file_name = Str::random(10) . '.' . $contest_file->getClientOriginalExtension();

                // Move to location
                Storage::putFileAs('public/contest-files/' . $request->contest_id, $contest_file, $contest_file_name);

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

    public function payment(Request $request, Contest $contest)
    {
        // dd($contest);
        if ($request->isMethod('post')) {
            // TODO: Verify Payment

            // Save payment
            $contest_payment = new ContestPayment();
            $contest_payment->contest_id = $contest->id;
            $contest_payment->amount = $request->amount;
            $contest_payment->payment_reference = $request->payment_reference;
            $contest_payment->payment_method = $request->payment_method;
            $contest_payment->paid = true;
            $contest_payment->save();

            $contest->ends_at = now()->addDays($contest->duration);
            $contest->save();

            return response()->json([
                'message' => 'Payment Saved successfully',
                'success' => true
            ]);
        }

        $user = auth()->check() ? auth()->user() : null;

        return view('contests.payment', compact('contest', 'user'));
    }

    public function extend_contest(Request $request){
        try {
            //code...
            if($contest = Contest::find($request->contest_id)){
                $contest->ends_at = now()->addDays($contest->duration);
                $contest->save();
            }
            return redirect()->back()->with('success', 'Contest Extended Succesfully');


        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function submit(Request $request, $contest_slug)
    {
        try {
            Log::info($request->all());
            if ($contest = Contest::where("slug", $contest_slug)->first()) {
                // Check that contest is still active and open
                if (is_null($contest->ends_at)) {
                    throw new \Exception(
                        "This contest is currently inactive.",
                        1
                    );
                } elseif ($contest->ends_at <= Carbon::now()) {
                    throw new \Exception(
                        "This contest has ended already.",
                        1
                    );
                } elseif(!is_null($contest->ended_at)){
                    throw new \Exception(
                        "This contest has ended already.",
                        1
                    );
                }

                // TODO: verify ended at

                // Generate Reference Number
                $reference_number = '';

                for ($i = 0; $i < 10; $i++) {
                    $reference_number .= "" . rand(0, 9);
                }

                // Save submission
                $contest_submission = new ContestSubmission();
                $contest_submission->contest_id = $contest->id;
                $contest_submission->user_id = auth()->user()->id;
                $contest_submission->reference = $reference_number;
                $contest_submission->description = $request->description;
                $contest_submission->save();

                foreach ($request->file('files') as $submission_file) {
                    $submission_file_name = Str::random(10) . '.' . $submission_file->getClientOriginalExtension();

                    // Move to location
                    Storage::putFileAs('public/contest-submission-files/' . $request->contest_id, $submission_file, $submission_file_name);

                    $contest_submission_file = new ContestSubmissionFile();
                    $contest_submission_file->contest_submission_id = $contest_submission->id;
                    $contest_submission_file->content = $submission_file_name;
                    $contest_submission_file->save();
                }

                try {
                    // $freelancer = User::find($offer->offer_user_id);
                    $contest = Contest::find($contest_submission->contest_id);
                    Mail::to($contest->user->email)
                    ->send(new NewContestSubmission($contest_submission->id));
                    Log::alert("email sent sucessfully for to {$contest->user->email} for new contest submission");
                } catch (\Throwable $th) {
                    Log::alert("email for new contest submission {$contest->user->email} failed to send due to " . $th->getMessage());
                }

                return response()->json([
                    'message' => 'Your submission has been received successfully',
                    'success' => true
                ]);
            }

            throw new \Exception("Invalid Contest", 1);
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function submissionComment(Request $request, $contest_slug, ContestSubmission $submission)
    {
        try {
            $user = auth()->user();

            if (!$contest = Contest::where('slug', $contest_slug)->first()) {
                abort(404);
            }
            if ($submission->user_id != $user->id && $submission->contest->user_id != $user->id) {
                throw new \Exception("Sorry, you are not authorised to view the requested page.", 1);
            }

            $comment = new ContestSubmissionComment();
            $comment->user_id = $user->id;
            $comment->contest_submission_id = $submission->id;

            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $submission_file) {
                    $file_name = Str::random(10) . '.' . $submission_file->getClientOriginalExtension();

                    // Move to location
                    Storage::putFileAs('public/contest-submission-comment-images/' . $submission->id, $submission_file, $file_name);
                    array_push($images, $file_name);
                }
                $comment->content = json_encode($images);
                $comment->content_type = 'image';
            } elseif ($request->hasFile('files')) {
                $files = [];
                foreach ($request->file('files') as $submission_file) {
                    $file_name = Str::random(10) . '.' . $submission_file->getClientOriginalExtension();

                    // Move to location
                    Storage::putFileAs('public/contest-submission-raw-files/' . $submission->id, $submission_file, $file_name);
                    array_push($files, $file_name);
                }
                $comment->content = json_encode($files);
                $comment->content_type = 'file';
            } else {
                $this->validate($request, [
                    'comment' => 'bail|required|string',
                ]);
                $comment->content = $request->comment;
            }

            $comment->save();

            return response()->json([
                'message' => 'Comment saved successfully',
                'success' => true
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

    public function downloadSubmissionRawFile($contest_slug, ContestSubmission $submission, ContestSubmissionComment $comment)
    {
        // try {
        $user = auth()->user();
        if (!$contest = Contest::where('slug', $contest_slug)->first()) {
            abort(404);
        }

        // dd($user->id);
        // dd($comment);

        if ($submission->user_id != $user->id && $contest->user_id != $user->id) {
            throw new \Exception("You are not authorised to view the requested page", 1);
        }

        if ($comment->content_type == 'text') {
            throw new \Exception("Invalid request", 1);
        }

        $zip = Zip::create("storage/{$contest->title}.zip");

        foreach (json_decode($comment->content) as $file) {
            $file_path = public_path("storage/contest-submission-raw-files/{$submission->id}/{$file}");
            $zip->add($file_path);
        }

        $zip->listFiles();
        $zip->close();

        // dd($zip);

        return response()->download("storage/{$contest->title}.zip");
        // } catch (\Throwable $th) {
        //     return back()->with('danger', $th->getMessage());
        // }
    }

    public function submissions($contest_slug)
    {
        try {
            if ($contest = Contest::where('slug', $contest_slug)->first()) {
                $user_location_currency = getCurrencyFromLocation();

                return view("contests.submissions", compact("contest", 'user_location_currency'));
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (\Throwable $th) {
            return back()->with("danger", $th->getMessage());
        }
    }

    public function downloadSubmissionFiles($contest_slug, ContestSubmission $submission)
    {
        try {
            if ($contest = Contest::where('slug', $contest_slug)->first()) {
                $zip_file_name = "Submission {$submission->reference}.zip";

                // $zip = Zip::create($zip_file_name);

                $zip = Zip::create(storage_path("app/public/contest-submission-files/{$zip_file_name}"), true);
                foreach ($submission->files as $submission_file) {
                    $zip->add(storage_path("app/public/contest-submission-files/{$submission_file->content}"));
                }
                $zip->close();

                return response()->download(storage_path("app/public/contest-submission-files/{$zip_file_name}"));
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (\Throwable $th) {
            return back()->with("danger", $th->getMessage());
        }
    }

    public function winners(Request $request, $contest_slug)
    {
        try {
            if ($contest = Contest::where('slug', $contest_slug)->first()) {
                $this->validate($request, [
                    "winners" => "bail|required"
                ]);

                Log::info($request->all());

                foreach ($request->winners as $winner_position => $submission_id) {
                    if (!is_null($submission_id)) {
                        if ($submission = $contest->submissions->where("id", $submission_id)->first()) {
                            $submission->position = $winner_position;
                            $submission->save();
                        }
                    }
                    // Log::info("{$winner_position} : {$submission_id}");
                }

                $contest->ended_at = now();
                $contest->save();

                return response()->json([
                    'message' => 'Contest ended successfully.',
                    'success' => true
                ]);
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function submissionCompleted(Request $request, $contest_slug, ContestSubmission $submission)
    {
        try {
            if (Contest::where('slug', $contest_slug)->count() > 0) {
                $user = auth()->user();

                if ($submission->user_id != $user->id && $submission->contest->user_id != $user->id) {
                    throw new \Exception("Sorry, you are not authorised to view the requested page.", 1);
                }

                if ($submission->comments->where('content_type', 'file')->count() < 1) {
                    throw new \Exception("Raw files have not been received for this submission.", 1);
                }

                if (is_null($submission->position)) {
                    throw new \Exception("This submission was not marked as one of the winners for the contest.", 1);
                }

                $submission->completed = true;
                $submission->save();

                return response()->json([
                    'message' => 'Submission completed successfully.',
                    'success' => true
                ]);
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->validator->errors()->first(),
                'success' => false
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function submission($contest_slug, ContestSubmission $submission)
    {
        try {
            $user = auth()->user();
            if ($contest = Contest::where('slug', $contest_slug)->first()) {

                if ($submission->user_id != $user->id && $submission->contest->user_id != $user->id) {
                    throw new \Exception("Sorry, you are not authorised to view the requested page.", 1);
                }

                $user_location_currency = getCurrencyFromLocation();

                return view("contests.submission", compact("contest", "submission", "user_location_currency"));
            }
            throw new \Exception("Invalid Contest", 1);
        } catch (\Throwable $th) {
            return back()->with("danger", $th->getMessage());
        }
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