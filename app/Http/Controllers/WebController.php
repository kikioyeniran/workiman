<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Torann\GeoIP\Facades\GeoIP;

class WebController extends Controller
{
    public function index()
    {
        $location = GeoIP::getLocation();

        // dd($location);
        return view('index');
    }

    public function search(Request $request)
    {
        try {
            $this->validate($request, [
                "keyword" => "bail|required",
                "category" => "bail|required|in:project-managers,freelancers,contests"
            ]);

            switch ($request->category) {
                case 'contests':
                    return redirect()->route("contests.index", ["keyword" => $request->keyword]);
                    break;
                case 'project-managers':
                    return redirect()->route("offers.project-managers.index", ["keyword" => $request->keyword]);
                    break;
                case 'freelancers':
                    return redirect()->route("offers.freelancers.index", ["keyword" => $request->keyword]);
                    break;
                default:
                    throw new \Exception("Please select a valid search category.", 1);
                    break;
            }
        } catch (ValidationException $th) {
            return back()->with("danger", $th->validator->errors()->first());
        } catch (\Exception $th) {
            return back()->with("danger", $th->getMessage());
        }
    }
}
