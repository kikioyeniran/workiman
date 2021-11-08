<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'as' => "index",
    'uses' => 'WebController@index'
]);

Route::get('search', [
    'as' => "search",
    'uses' => 'WebController@search'
]);

Route::get('terms', [
    'as' => "terms",
    'uses' => 'WebController@terms'
]);

Route::get('privacy-policy', [
    'as' => "privacy-policy",
    'uses' => 'WebController@privacy_policy'
]);

Route::post('newsletters', [
    'as' => "newsletter-subscription",
    'uses' => 'WebController@newsletter'
]);