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

Route::get('/errors', [
    'as' => "error",
    'uses' => 'WebController@error_page'
]);

Route::get('/how-it-works', [
    'as' => "how-it-works",
    'uses' => 'WebController@how_it_works'
]);

Route::get('search', [
    'as' => "search",
    'uses' => 'WebController@search'
]);

Route::get('terms', [
    'as' => "terms",
    'uses' => 'WebController@terms'
]);


Route::match(['get', 'post'], 'contact', [
    'as' => 'contact',
    'uses' =>  'WebController@contact'
]);

Route::get('privacy-policy', [
    'as' => "privacy-policy",
    'uses' => 'WebController@privacy_policy'
]);

Route::get('clear-notifications/{user}', [
    'as' => "clear-notifications",
    'uses' => 'WebController@clear_notifications'
]);

Route::post('newsletters', [
    'as' => "newsletter-subscription",
    'uses' => 'WebController@newsletter'
]);
