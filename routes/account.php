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

Route::get('conversations/{username?}', [
    'as' => 'account.conversations',
    'uses' => 'MessagesController@index',
    'middleware' => 'account'
]);

Route::post('conversations/send-message', [
    'as' => 'account.conversations.send-message',
    'uses' => 'MessagesController@sendMessage',
    'middleware' => 'account'
]);