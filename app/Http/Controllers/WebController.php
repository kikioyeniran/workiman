<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        // dd(parse_url('mysql://b8dbb3182de3fe:fb018543@us-cdbr-iron-east-02.cleardb.net/heroku_4797e91'));
        return view('index');
    }
}
