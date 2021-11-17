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

Route::get('assigned/{username}', [
    'as' => 'offers.assigned',
    'uses' => 'OfferController@assignedOffers'
]);

Route::match(['get', 'post'], 'new', [
    'as' => 'offers.new',
    'uses' =>  'OfferController@new'
])->middleware('account');

Route::match(['get', 'post'], 'freelancer/{offer}', [
    'as' => 'offers.freelancer.edit',
    'uses' =>  'OfferController@update'
])->middleware('account');

Route::match(['get', 'post'], 'project-manager/{offer}', [
    'as' => 'offers.project-manager.edit',
    'uses' =>  'OfferController@updateProjectManagerOffer'
])->middleware('account');

// Route::get('project-manager/validate-update/{offer}/{old_budget}', [
//     'as' => 'offers.project-manager.validate-update',
//     'uses' =>  'OfferController@validate_update'
// ])->middleware('account');

// Route::match(['get', 'post'], 'project-manager/update-offer-payment/{offer}/{amount}', [
//     'as' => 'offers.project-manager.update-payment',
//     'uses' =>  'OfferController@update_offer_payment'
// ])->middleware('account');

Route::group(
    [
        'middleware' => 'project-manager',
    ],
    function () {
        Route::match(['get', 'post'], 'offer-freelancer/{offer_slug}', [
            'as' => 'offers.offer-freelancer',
            'uses' =>  'OfferController@offerFreelancer'
        ])->middleware('account');

        Route::match(['get', 'post'], 'payment/project-managers/{offer}', [
            'as' => 'offers.project-managers.payment',
            'uses' => 'OfferController@payment'
        ]);

        Route::match(['get', 'post'], 'payment-top-up/project-managers/{offer}/{amount}', [
            'as' => 'offers.project-managers.payment-top-up',
            'uses' => 'OfferController@budgetTopUp'
        ]);

        Route::post('assign-freelancer/{offer}', [
            'as' => 'offers.project-managers.assign-freelancer',
            'uses' => 'OfferController@assignFreelancer'
        ]);

        Route::get('completed/project-managers/{offer}', [
            'as' => 'offers.project-managers.completed',
            'uses' => 'OfferController@completed'
        ]);

        Route::match(['get', 'post'], 'project-managers/{offer_slug}/interested-freelancers', [
            'as' => 'offers.project-managers.interested-freelancers',
            'uses' => 'OfferController@interestedFreelancers'
        ]);
    }
);

Route::group(
    [
        'middleware' => 'project-manager',
    ],
    function () {
        Route::post('interest/project-managers/{offer}', [
            'as' => 'offers.project-managers.interest',
            'uses' => 'OfferController@interest'
        ]);
    }
);

Route::post('comment/project-managers/{offer}', [
    'as' => 'offers.project-managers.comment',
    'uses' => 'OfferController@comment'
]);

Route::get('download-file/project-managers/{comment}', [
    'as' => 'offers.project-managers.download-file',
    'uses' => 'OfferController@downloadFile',
    'middleware' => 'account'
]);

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