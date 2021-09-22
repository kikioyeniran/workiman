<?php

namespace App\Http\Controllers\Auth;

use App\Contest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => ['bail', 'required', 'string'],
                'password' => ['bail', 'required'],
            ]);

            // TODO: Sign user in
            if (!$authAttempt = auth()->attempt([
                "username" => $request->username,
                "password" => $request->password
            ])) {
                $authAttempt = auth()->attempt([
                    "email" => $request->username,
                    "password" => $request->password
                ]);
            }

            if ($authAttempt) {
                if ($request->has('contest_id') && $contest = Contest::find($request->contest_id)) {
                    $contest->user_id = auth()->user()->id;
                    $contest->save();

                    return back()->with('success', 'Login Successful');
                }

                if (auth()->user()->admin) {
                    // Redirect to account dashboard
                    return redirect()->route('admin.dashboard');
                }

                // Redirect to account dashboard
                return back()->with("success", "Login Successful");
                // return redirect()->route('account');
            }

            throw new \Exception("Invalid Login", 1);
        } catch (ValidationException $exception) {
            return redirect()->back()->with('danger', $exception->validator->errors()->first())->with('login' . $request->has('contest_id') ? '_' : '', true)->withInput();
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage())->with('login' . $request->has('contest_id') ? '_' : '', true)->withInput();
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function socialRedirect($provider)
    {
        return Socialite::driver($provider)
            ->with(['redirect_url' => URL::previous()])
            ->redirect();
    }

    public function socialCallback($provider)
    {
        // $user = Socialite::driver($provider)->user();

        $userSocial =   Socialite::driver($provider)->user();
        $users       =   User::where(['email' => $userSocial->getEmail()])->first();

        if($users){
            Auth::login($users);
            return redirect()->route('account')->with("success", "Login Successful");
            // return redirect('/');
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
         return redirect()->route('home');
        }
}

        // $user->token

        // dd($user);

}