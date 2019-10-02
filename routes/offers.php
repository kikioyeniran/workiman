<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'offers',
    'uses' => 'OfferController@index'
]);

Route::get('user/{username}', [
    'as' => 'offers.user',
    'uses' => 'OfferController@userOffers'
]);

Route::match(['get', 'post'], 'new', [
    'as' => 'offers.new',
    'uses' =>  'OfferController@new'
])->middleware('account');
