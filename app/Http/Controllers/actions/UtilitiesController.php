<?php

namespace App\Http\Controllers\actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    //
    public function fileNameToStore($image)
    {
        //Get file name with extension
        $filenameWithExt = $image->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //Join if there's spave in filename
        $new_arr = explode(" ", $filename);
        if ($new_arr) {
            $filename = join("-", $new_arr);
        }
        // Get just ext
        $extension = $image->getClientOriginalExtension();
        //Filename to store
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        // $fileNameToStore = $filename . '.' . $extension;
        //Upload image
        $path = $image->storeAs('public/pictures', $fileNameToStore);
        return $fileNameToStore;
    }
}