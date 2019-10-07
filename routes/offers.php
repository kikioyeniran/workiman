<?php

use Illuminate\Support\Facades\Route;

Route::get('user/{username}', [
    'as' => 'offers.user',
    'uses' => 'OfferController@userOffers'
]);

Route::match(['get', 'post'], 'new', [
    'as' => 'offers.new',
    'uses' =>  'OfferController@new'
])->middleware('account');

Route::post('images', [
    'as' => 'offer.images',
    'uses' => 'OfferController@images'
]);

Route::get('freelancers/{id?}', [
    'as' => 'offers.freelancers',
    'uses' => 'OfferController@index'
]);

Route::get('project-managers/{id?}', [
    'as' => 'offers.project-managers',
    'uses' => 'OfferController@projectManagerOffers'
]);
