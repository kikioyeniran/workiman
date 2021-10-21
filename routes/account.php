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

Route::post('contest/dispute', [
    'as' => 'account.contests.dispute',
    'uses' => 'AccountController@hold_contest',
    // 'middleware' => 'acc'
]);

Route::post('project-manager-offer/dispute', [
    'as' => 'account.project-manager-offer.dispute',
    'uses' => 'AccountController@hold_project_manager_offer',
    // 'middleware' => 'acc'
]);

Route::post('freelancers-offer/dispute', [
    'as' => 'account.freelancers-offer.dispute',
    'uses' => 'AccountController@hold_freelancer_offer',
    // 'middleware' => 'acc'
]);

Route::post('wallet-withdrawal', [
    'as' => 'account.wallet-withdrawal',
    'uses' => 'AccountController@walletWithdrawal',
    'middleware' => 'freelancer'
]);

Route::post('verify-account-number', [
    'as' => 'account.verify-account-number',
    'uses' => 'AccountController@verifyAccountNumber'
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