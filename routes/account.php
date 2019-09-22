<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'account',
    'uses' => 'AccountController@dashboard'
]);

Route::match(['get', 'put'], 'settings', [
    'as' => 'account.settings',
    'uses' => 'AccountController@settings'
]);
