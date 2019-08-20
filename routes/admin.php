<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'admin.dashboard',
    'uses' => 'AdminController@dashboard'
]);

Route::group(['prefix' => 'contests'], function ()
{
    Route::match(['get', 'post'], 'categories', [
        'as' => 'admin.contests.categories',
        'uses' => 'ContestController@categories'
    ]);

    Route::resource('', 'ContestController')->names([
        'index' => 'admin.contests.index'
    ]);
});
