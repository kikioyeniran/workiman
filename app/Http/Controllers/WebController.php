<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Contest;
use App\ContestCategory;
use App\Mail\ContactForm;
use App\Newsletter;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
// use Torann\GeoIP\Facades\GeoIP;
use App\Notifications\Account\VerifyEmail;
use App\Slider;
use App\Testimonial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $user_location_currency = getCurrencyFromLocation();
        // dd($user_location_currency);
        // return getCurrencyAmount("naira", 900, $currency->name);

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
        // $location = GeoIP::getLocation();

        $contest_categories = ContestCategory::take(8)->get();

        // $featured_contests = Contest::whereHas('payment')->inRandomOrder()->take(8)->get();
        $featured_contests = Contest::whereNotNull('ended_at')->inRandomOrder()->take(8)->get();

        $featured_freelancers = User::where('freelancer', true)->where('disabled', false)->inRandomOrder()->take(8)->get();
        // $featured_freelancers = User::where('freelancer', true)->where('disabled', false)->first();
        // dd($featured_freelancers->country);

        $sliders = Slider::where('disabled', false)->get();
        $testimonials = Testimonial::where('disabled', false)->get();

        return view('index', compact('contest_categories', 'featured_contests', 'featured_freelancers', 'user_location_currency', 'sliders', 'testimonials'));
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
                    return redirect()->route("contests.index", ["keyword" => $request->keyword, "category" => $request->contest_category, "freelancer_level" => $request->freelancer_level]);
                    break;
                case 'project-managers':
                    return redirect()->route("offers.project-managers.index", ["keyword" => $request->keyword, "category" => $request->offer_category]);
                    break;
                case 'freelancers':
                    return redirect()->route("offers.freelancers.index", ["keyword" => $request->keyword, "category" => $request->offer_category]);
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

    public function terms(){
        return view('terms');
    }

    public function privacy_policy(){
        return view('privacy-policy');
    }

    public function newsletter(Request $request){
        try {
            //code...
            $this->validate($request, [
                "email" => "bail|required|email",
            ]);

            $newsletter = new Newsletter();
            $newsletter->email = $request->email;
            $newsletter->save();

            return redirect()->back()->with('success', 'Your email has been saved');
        } catch (ValidationException $th) {
            return back()->with("danger", $th->validator->errors()->first());
        } catch (\Exception $th) {
            return back()->with("danger", $th->getMessage());
        }
    }

    public function contact(Request $request){
        try {

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'name' => 'required|bail',
                    'phone' => 'required|bail',
                    'email' => 'required|bail',
                    'subject' => 'required|bail',
                    'message' => 'required|bail'
                ]);
                $contact = new Contact();
                $contact->name = $request->name;
                $contact->phone = $request->phone;
                $contact->email = $request->input('email');
                $contact->message = $request->message;
                $contact->subject = $request->subject;
                $contact->save();
                try {
                    $admin = "drummistrel@gmail.com";
                    Mail::to($admin)
                        ->send(new ContactForm($contact->id));
                    Log::alert("email sent sucessfully for contact form to {$admin}");
                } catch (\Throwable $th) {
                    Log::alert("email for new offer with id {$contact->id} failed to send due to " . $th->getMessage());
                }
                return redirect()->back()->with('success', 'Your Message Has been Sent Successfully!');
            }

            return view('contact');
        } catch (ValidationException $exception) {
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            return back()->with('danger', $exception->getMessage());
        }
    }
}