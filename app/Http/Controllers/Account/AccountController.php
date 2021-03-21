<?php

namespace App\Http\Controllers\Account;

use App\Bank;
use App\Contest;
use App\Country;
use App\Freelancer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentMethod;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['account', 'verified'])->except('profile');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $countries = Country::get();
        $suggested_contests = [];

        if ($user->freelancer) {
            $suggested_contests = Contest::where(function ($query) use ($user) {
                $query->whereHas('submissions', function ($submission) use ($user) {
                    $submission->whereDoesntHave('user', function ($submission_user) use ($user) {
                        $submission_user->where('id', $user->id);
                    });
                })->orWhereDoesntHave('submissions');
            })
                ->whereNull("ended_at")->whereNotNull("ends_at")->where("ends_at", ">", now())
                ->orderBy('created_at', 'desc')->take(3)->get();
        }

        return view('account.dashboard', compact('user', 'countries', 'suggested_contests'));
    }

    public function settings(Request $request)
    {
        try {
            $user = auth()->user();
            $countries = Country::get();
            $banks = Bank::get();

            // dd($request);

            if ($request->isMethod('put')) {
                switch ($request->setting) {
                    case 'basic':
                        $this->validate($request, [
                            'first_name' => 'bail|required|string',
                            'last_name' => 'bail|required|string',
                            'username' => 'bail|required|string',
                            'country' => 'bail|required|string',
                            'phone' => 'bail|required|string',
                        ]);

                        if (!$country = Country::where('id', $request->country)->first()) {
                            throw new \Exception("Invalid Country", 1);
                        }

                        if ($request->phone != $user->phone) {
                            $this->validate($request, [
                                'phone' => 'unique:users'
                            ]);
                        }

                        $user->first_name = $request->first_name;
                        $user->last_name = $request->last_name;
                        $user->username = $request->username;
                        $user->country_id = $country->id;
                        $user->phone = $request->phone;

                        if (!$request->hasFile('avatar') && !$user->avatar) {
                            throw new \Exception("Please add a profle picture", 1);
                        } elseif ($request->hasFile('avatar')) {
                            $avatar = $request->file('avatar');
                            $user->avatar = Str::random(10) . '.' . $avatar->getClientOriginalExtension();
                            Storage::putFileAs('public/avatars', $avatar, $user->avatar);
                        }

                        // dd($user);

                        $user->save();

                        return redirect()->route('account.settings')->with('success', 'Profile saved successfully');

                        break;
                    case 'skills':
                        $this->validate($request, [
                            'skills' => 'bail|required|string',
                            // 'awards' => 'bail|required|string',
                            'portfolio' => 'bail|required|string',
                            'social_media' => 'bail|required|string'
                        ]);

                        if (!$freelancer_profile = Freelancer::where('user_id', $user->id)->first()) {
                            $freelancer_profile = new Freelancer();
                            $freelancer_profile->user_id = $user->id;
                        }

                        $freelancer_profile->portfolio = $request->portfolio;
                        $freelancer_profile->social_media = $request->social_media;
                        $freelancer_profile->skills = $request->skills;
                        $freelancer_profile->awards = $request->awards;

                        // if(!$request->hasFile('cover_letter') && !$freelancer_profile->cover_letter)
                        // {
                        //     throw new \Exception("Please add a cover_letter", 1);
                        // } elseif($request->hasFile('cover_letter'))
                        // {
                        //     $cover_letter = $request->file('cover_letter');
                        //     $freelancer_profile->cover_letter = Str::random(10).'.'.$cover_letter->getClientOriginalExtension();
                        //     Storage::putFileAs('public/cover_letters', $cover_letter, $freelancer_profile->cover_letter);
                        // }

                        // dd($freelancer_profile);

                        $freelancer_profile->save();

                        return redirect()->route('account.settings')->with('success', 'Profile saved successfully');

                        break;
                    case 'payment':
                        $this->validate($request, [
                            'payment_method' => 'bail|required|string'
                        ]);

                        if (is_null($user->payment_method)) {
                            $user->payment_method = new PaymentMethod();
                            $user->payment_method->user_id = $user->id;
                        }

                        switch ($request->payment_method) {
                            case 'bank':
                                $this->validate($request, [
                                    'bank' => 'bail|required|string',
                                    'account_number' => 'bail|required|string',
                                    'account_name' => 'bail|required|string',
                                ]);
                                $user->payment_method->bank = $request->bank;
                                $user->payment_method->account_number = $request->account_number;
                                $user->payment_method->account_name = $request->account_name;
                                $user->payment_method->email = null;
                                break;
                            default:
                                $this->validate($request, [
                                    'payment_email' => 'bail|required|email',
                                ]);
                                $user->payment_method->email = $request->payment_email;
                                $user->payment_method->bank = null;
                                $user->payment_method->account_number = null;
                                $user->payment_method->account_name = null;
                                # code...
                                break;
                        }

                        $user->payment_method->method = $request->payment_method;

                        $user->payment_method->save();

                        return redirect()->route('account.settings')->with('success', 'Profile saved successfully');

                        break;
                    case 'password':

                        if (!auth()->attempt([
                            'email' => auth()->user()->email,
                            'password' => $request->password_old
                        ])) {
                            throw new \Exception("Invalid Password", 1);
                        }

                        $this->validate($request, [
                            'password_old' => 'bail|required|string',
                            'password' => 'bail|required|confirmed',
                        ]);

                        $user->password = bcrypt($request->password);

                        $user->payment_method->save();

                        return redirect()->route('account.settings')->with('success', 'Profile saved successfully');

                        break;
                    default:
                        # code...
                        break;
                }

                // dd($request);

                throw new \Exception("Invalid Profile Modification", 1);
            }

            return view('account.settings', compact('user', 'countries', 'banks'));
        } catch (ValidationException $exception) {
            // dd($exception->validator->errors()->first());
            return back()->with('danger', $exception->validator->errors()->first());
        } catch (\Exception $exception) {
            // dd($exception->getMessage());
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function profile($username = null)
    {
        if ($username) {
            $user = User::where('username', $username)->first();
        } else {
            if (auth()->check())
                $user = auth()->user();
            else
                return redirect()->route('index')->with('danger', 'Please sign in to continue');
        }

        if ($user) {
            return view('account.profile', compact('user'));
        }

        abort(404, "Invalid User");
    }
}