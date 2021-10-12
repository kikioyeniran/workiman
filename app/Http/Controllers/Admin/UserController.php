<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($user_category)
    {
        $users = User::whereNotNull('id');
        if ($user_category == 'freelancers') {
            $users = $users->where('freelancer', true);
        } elseif ($user_category == 'project-managers') {
            $users = $users->where('freelancer', false);
        }
        // elseif ($user_category == 'admin') {
        //     $users = $users->where('admin', true);
        // }
        // $users = $users->where('disabled', false)->get();
        $users = $users->get();

        return view("admin.users.index", compact('users', 'user_category'));
    }

    public function disable($id){
        $user = User::find($id);
        $user->disabled = true;
        $user->save();
        return redirect()->route('admin.users.index', ['user_category' => 'project-managers'])->with('success', 'User Disabled');
    }

    public function restore($id){
        $user = User::find($id);
        $user->disabled = false;
        $user->save();
        return redirect()->route('admin.users.index', ['user_category' => 'project-managers'])->with('success', 'User Restored');
    }
}