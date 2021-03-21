<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'account',
    'uses' => 'AccountController@dashboard'
]);

Route::match(['get'], 'profile/{username?}', [
    'as' => 'account.profile',
    'uses' => 'AccountController@profile'
]);

Route::match(['get', 'put'], 'settings', [
    'as' => 'account.settings',
    'uses' => 'AccountController@settings'
]);