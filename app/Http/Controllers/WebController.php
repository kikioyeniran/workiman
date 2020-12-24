<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class WebController extends Controller
{
    public function index()
    {
        $location = GeoIP::getLocation();

        dd($location);
        return view('index');
    }
}
