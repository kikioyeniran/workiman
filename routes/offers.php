<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Offers\FreelancerOfferContoller;


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

        Route::match(['get', 'post'], 'payment/freelancer-offer/{interest}', [
            'as' => 'offers.freelancers.payment',
            'uses' => 'OfferController@freelancer_offer_payment'
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
        'middleware' => 'freelancer',
    ],
    function () {
        Route::post('interest/project-managers/{offer}', [
            'as' => 'offers.project-managers.interest',
            'uses' => 'OfferController@interest'
        ]);

        Route::post('interest/submission/{interest}', [
            'as' => 'offers.interest.submit',
            'uses' => 'OfferController@interest_submission'
        ]);

        Route::get('paid-offer-intrests/{user}', [
            'as' => 'offers.paid-interests',
            'uses' => 'OfferController@freelancerPaidOffers'
        ]);

        Route::get('pending-offer-interests/{user}', [
            'as' => 'offers.pending-interests',
            'uses' => 'OfferController@freelancerPendingOffers'
        ]);

        Route::get('freelancer-offer/accept/{interest}', [
            'as' => 'offers.accept-interest',
            'uses' => 'OfferController@acceptFreelancerOfferInterest'
        ]);

        Route::get('freelancer-offer/decline/{interest}', [
            'as' => 'offers.decline-interest',
            'uses' => 'OfferController@declineFreelancerOfferInterest'
        ]);

        // Route::get('freelancer-offer/disable/{offer}', [
        //     'as' => 'offers.freelancer.disable',
        //     'uses' => 'FreelancerOfferController@disable'
        // ]);

        Route::get('freelancer-offer/disable/{offer}', [FreelancerOfferContoller::class, 'disable'])->name('offers.freelancer.disable');

        Route::get('freelancer-offer/restore/{offer}', [
            'as' => 'offers.freelancer.restore',
            'uses' => 'FreelancerOfferController@restore'
        ]);

        Route::get('freelancer-offer/disabled', [
            'as' => 'offers.freelancer.disabled',
            'uses' => 'FreelancerOfferController@restore'
        ]);
    }

);

Route::group(
    [
        'middleware' => 'project-manager',
    ],
    function () {
        Route::post('interest/freelancers/{offer}', [
            'as' => 'offers.freelancers.interest',
            'uses' => 'OfferController@freelancer_offer_interest'
        ]);

        Route::get('interest/project-managers/duplicate/{offer}', [
            'as' => 'offers.project-managers.duplicate',
            'uses' => 'OfferController@duplicate_offer'
        ]);

        Route::get('project-managers/paid-offer-interests/{user}', [
            'as' => 'offers.project-managers.paid-interests',
            'uses' => 'OfferController@projectManagerPaidOffers'
        ]);

        Route::get('project-managers/offer-interests/{user}', [
            'as' => 'offers.project-managers.offer-interests',
            'uses' => 'OfferController@projectManagerOfferInterests'
        ]);
    }
);
Route::get('paid-offer-interest/{offer}/{interest}', [
    'as' => 'offers.paid-interests.show',
    'uses' => 'OfferController@freelancerPaidOfferDetail',
    'middleware' => 'account'
]);

Route::get("{offer}/submission/{submission}/download-files", [
    "as" => "offers.submission.download-files",
    "uses" => "OfferController@downloadSubmissionFiles"
]);

Route::post('comment/project-managers/{offer}', [
    'as' => 'offers.project-managers.comment',
    'uses' => 'OfferController@comment'
]);

Route::get('download-file/project-managers/{comment}', [
    'as' => 'offers.project-managers.download-file',
    'uses' => 'OfferController@downloadFile',
    'middleware' => 'account'
]);

Route::get('offer-submission/show/{interest}/{submission}', [
    'as' => 'offers.submission.show',
    'uses' => 'OfferController@submission',
    'middleware' => 'account'
]);

Route::post('{interest}/comment/submissions/{submission}', [
    'as' => 'offers.submission.comment',
    'uses' => 'OfferController@submissionComment'
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
    'uses' => 'OfferController@projectManagerOffers',
    'middleware' => 'account'
]);

Route::post("project-managers/filter", [
    "as" => "offers.project-managers.filter",
    "uses" => "OfferController@projectManagerFilter",
    'middleware' => 'account'
]);

Route::get('project-managers/{offer_slug}', [
    'as' => 'offers.project-managers.show',
    'uses' => 'OfferController@projectManagerOffer',
    'middleware' => 'account'
]);

Route::get('freelancers', [
    'as' => 'offers.freelancers.index',
    'uses' => 'OfferController@freelancerOffers',
    'middleware' => 'account'
]);

Route::post("freelancers/filter", [
    "as" => "offers.freelancers.filter",
    "uses" => "OfferController@freelancerFilter",
    'middleware' => 'account'
]);

Route::get('freelancers/{offer_slug}', [
    'as' => 'offers.freelancers.show',
    'uses' => 'OfferController@freelancerOffer',
    'middleware' => 'account'
]);
