<?php

namespace App\Http\Controllers\Auth;

use App\Contest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

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
}
