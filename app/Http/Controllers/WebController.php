<?php

namespace App\Http\Controllers;

use App\Contest;
use App\ContestCategory;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Torann\GeoIP\Facades\GeoIP;
use App\Notifications\Account\VerifyEmail;
use Illuminate\Support\Facades\Log;

class WebController extends Controller
{
    public function index(Request $request)
    {
        // ?state=5LBgieBV4uPDup1keELtFIfxBlmeQ1INLMWWl1FT&code=4%2F0AY0e-g6jDr97C6zniwK9BD02SAo2Jk89aIj27IIVkiGdcxj4tNSOLFpg3dcr5JaiL2C-wQ&scope=email+profile+openid+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&authuser=0&prompt=consent#
        // ?state=l83O6m7Vj6RKpEB3aubxHL88Q6lcN2sZAaHmIoRj&code=4%2F0AY0e-g6XM3iVLxGJS0ls7fPA8aN1F3cQGIHl-x5YIL4Imz1W0ElPv4rrzJmJcwA8UemWDA&scope=email+profile+openid+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&authuser=0&prompt=none#
        if ($request->has('state')) {
            try {
                $social_user = Socialite::driver('google')->user();

                // dd($social_user);
                Log::info(json_encode($social_user));

                if (!$user = User::where('email', $social_user->email)->first()) {
                    $user = new User();
                    $user->username = $social_user->email;
                    $user->email = $social_user->email;
                    $user->first_name = $social_user->user['given_name'];
                    $user->last_name = $social_user->user['family_name'];
                    $user->password = bcrypt(123456);
                    $user->save();

                    // Send verification email to user
                    try {
                        $user->notify(new VerifyEmail($user));
                    } catch (\Throwable $th) {
                        Log::info("User verification email was not sent due to {$th->getMessage()}");
                    }
                }

                auth()->loginUsingId($user->id);
            } catch (\Throwable $th) {
                Log::error("Could not authenticate socially: {$th->getMessage()}");
            }


            // if ($request->has('contest_id') && $contest = Contest::find($request->contest_id)) {
            //     $contest->user_id = auth()->user()->id;
            //     $contest->save();

            //     return back()->with('success', 'Login Successful');
            // }

            // dd($user);
        }

        // Log::info('message');
        $location = GeoIP::getLocation();

        $contest_categories = ContestCategory::take(8)->get();

        $featured_contests = Contest::whereHas('payment')->inRandomOrder()->take(3)->get();

        $featured_freelancers = User::where('freelancer', true)->inRandomOrder()->take(8)->get();

        return view('index', compact('contest_categories', 'featured_contests', 'featured_freelancers'));
    }

    public function search(Request $request)
    {
        try {
            $this->validate($request, [
                "keyword" => "bail|required",
                "category" => "bail|required|in:project-managers,freelancers,contests"
            ]);

            switch ($request->category) {
                case 'contests':
                    return redirect()->route("contests.index", ["keyword" => $request->keyword]);
                    break;
                case 'project-managers':
                    return redirect()->route("offers.project-managers.index", ["keyword" => $request->keyword]);
                    break;
                case 'freelancers':
                    return redirect()->route("offers.freelancers.index", ["keyword" => $request->keyword]);
                    break;
                default:
                    throw new \Exception("Please select a valid search category.", 1);
                    break;
            }
        } catch (ValidationException $th) {
            return back()->with("danger", $th->validator->errors()->first());
        } catch (\Exception $th) {
            return back()->with("danger", $th->getMessage());
        }
    }
}