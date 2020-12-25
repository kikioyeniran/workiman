<?php

use Illuminate\Support\Facades\Route;

Route::get("", [
    "as" => "contests.index",
    "uses" => "ContestController@index"
]);

Route::post("filter", [
    "as" => "contests.filter",
    "uses" => "ContestController@filter"
]);

Route::get("{slug}", [
    "as" => "contests.show",
    "uses" => "ContestController@show"
]);
