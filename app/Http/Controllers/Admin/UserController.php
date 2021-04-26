<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($user_category)
    {
        // $user_category = 'all';
        $users = User::whereNotNull('id');
        if ($user_category == 'freelancers') {
            $users = $users->where('freelancer', true);
        } elseif ($user_category == 'project-managers') {
            $users = $users->where('freelancer', false);
        }
        $users = $users->get();

        return view("admin.users.index", compact('users', 'user_category'));
    }
}