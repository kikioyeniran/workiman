<?php

use Illuminate\Support\Facades\Route;

Route::get("", [
    "as" => "offers.index",
    "uses" => "OfferController@index"
]);

Route::get('user/{username}', [
    'as' => 'offers.user',
    'uses' => 'OfferController@userOffers'
]);

Route::match(['get', 'post'], 'new', [
    'as' => 'offers.new',
    'uses' =>  'OfferController@new'
])->middleware('account');

Route::group(
    [
        'middleware' => 'project-manager',
    ],
    function () {
        Route::match(['get', 'post'], 'payment/project-managers/{offer}', [
            'as' => 'offers.project-managers.payment',
            'uses' => 'OfferController@payment'
        ]);
    }
);

Route::post('images', [
    'as' => 'offer.images',
    'uses' => 'OfferController@images'
]);

// Route::get('freelancers/{offer?}', [
//     'as' => 'offers.freelancers',
//     'uses' => 'OfferController@freelancerOffers'
// ]);

Route::get('project-managers', [
    'as' => 'offers.project-managers.index',
    'uses' => 'OfferController@projectManagerOffers'
]);

Route::post("project-managers/filter", [
    "as" => "offers.project-managers.filter",
    "uses" => "OfferController@projectManagerFilter"
]);

Route::get('project-managers/{offer_slug}', [
    'as' => 'offers.project-managers.show',
    'uses' => 'OfferController@projectManagerOffer'
]);

Route::get('freelancers', [
    'as' => 'offers.freelancers.index',
    'uses' => 'OfferController@freelancerOffers'
]);

Route::post("freelancers/filter", [
    "as" => "offers.freelancers.filter",
    "uses" => "OfferController@freelancerFilter"
]);

Route::get('freelancers/{offer_slug}', [
    'as' => 'offers.freelancers.show',
    'uses' => 'OfferController@freelancerOffer'
]);