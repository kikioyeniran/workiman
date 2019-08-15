<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'account',
    'uses' => 'AccountController@dashboard'
]);
