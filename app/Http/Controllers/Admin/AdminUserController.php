<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\NewAdminAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('disabled', false)->where('admin', true)->where('super_admin', false)->get();
        return view('admin.admin-users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $countries = Country::get();
        return view('admin.admin-users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|bail',
            'first_name' => 'required|bail',
            'last_name' => 'required|bail',
            'username' => 'required|bail',
        ]);
        $rand_password = Str::random(10);

        $user = new User();
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->password = Hash::make($rand_password);
        $user->admin = true;
        $user->temporary_password = $rand_password;
        $user->save();

        try {
            Mail::to($user->email)
            // ->bcc($dev, $admin)
            ->send(new NewAdminAccount($user->id));
            Log::alert("email sent sucessfully for to {$user->email}");
        } catch (\Throwable $th) {
            Log::alert("email to {$user->email } failed to send due to " . $th->getMessage());
        }

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin Account Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.admin-users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // dd($states);
        return view('admin.admin-users.edit', compact('user'));
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
        $this->validate($request, [
            'email' => 'required|bail',
            'first_name' => 'required|bail',
            'last_name' => 'required|bail',
        ]);

        $user = User::find($id);
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        // $user->password = Hash::make($rand_password);
        // $user->admin = true;
        // $user->temporary_password = $rand_password;
        $user->save();

        return redirect()->route('admin.admin-users.index')->with('success', 'Agent Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $user = User::find($id);
        $user->disabled = true;
        $user->save();
        return redirect()->route('admin.categories.index')->with('success', 'User Disabled');
    }

    // Restore Disabled category
    public function restore($id)
    {
        $user = User::find($id);
        $user->disabled = false;
        $user->save();
        return redirect()->route('admin.categories.disabled')->with('success', 'User Restored');
    }

    // Display Disabled Categories
    public function disabled()
    {
        $users = User::where('disabled', true)->where('admin', true)->where('super_admin', false)->get();
        return view('admin.admin-users.disabled', compact('users'));
    }
}