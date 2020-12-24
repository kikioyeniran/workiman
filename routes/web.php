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

Route::group(['prefix' => 'contest'], function () {
    Route::match(['get', 'post'], 'payment/{id}', [
        'as' => 'contest.payment',
        'uses' => 'Account\ContestController@payment'
    ]);

    Route::post('images', [
        'as' => 'contest.images',
        'uses' => 'Account\ContestController@images'
    ]);

    Route::resource('', 'Account\ContestController')->only([
        'create',
        'store',
    ])->names([
        'create' => 'contests.create',
        'store' => 'contests.store',
    ]);
});
