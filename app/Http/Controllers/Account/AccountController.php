<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        return view('account.dashboard', compact('user'));
    }
}
