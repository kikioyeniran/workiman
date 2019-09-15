<?php

namespace App\Http\Controllers\Account;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $countries = Country::get();

        return view('account.dashboard', compact('user', 'countries'));
    }
}
