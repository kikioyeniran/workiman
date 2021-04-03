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

Route::get('wallet', [
    'as' => 'account.wallet',
    'uses' => 'AccountController@wallet',
    'middleware' => 'freelancer'
]);

Route::match(['get', 'put'], 'settings', [
    'as' => 'account.settings',
    'uses' => 'AccountController@settings'
]);
