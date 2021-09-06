<?php

namespace App\Http\Controllers\Auth;

use App\Contest;
use App\User;
use App\Http\Controllers\Controller;
use App\Notifications\Account\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'account_type_radio' => ['bail', 'required', 'string'],
                'username' => ['bail', 'required', 'string', 'unique:users'],
                'email' => ['bail', 'required', 'string', 'unique:users'],
                'password' => ['bail', 'required', 'confirmed'],
            ]);

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            if ($request->has('account_type_radio') && $request->account_type_radio == 'freelancer') {
                $user->freelancer = true;
            }

            // dd($user);

            $user->save();

            auth()->loginUsingId($user->id);

            try {
                 // Send verification email to user
                $user->notify(new VerifyEmail($user));
                Log::alert("email sent sucessfully to {$user->email}");
            } catch (\Throwable $th) {
                Log::alert("email for user with id {$user->id} failed to send due to " . $th->getMessage());
            }

            if ($request->has('contest_id') && $contest = Contest::find($request->contest_id)) {
                $contest->user_id = auth()->user()->id;
                $contest->save();

                return back()->with('success', 'Login Successful');
            }

            // TODO: Sign user in


            // Redirect to account dashboard
            return redirect()->route('account');

            // throw new ValidationException("Error Processing Request", 1);

        } catch (ValidationException $exception) {
            return redirect()->back()->with('danger', $exception->validator->errors()->first())->with('register' . $request->has('contest_id') ? '_' : '', true)->withInput();
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage())->with('register' . $request->has('contest_id') ? '_' : '', true)->withInput();
        }
    }
}