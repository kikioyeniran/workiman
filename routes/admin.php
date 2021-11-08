<?php

use Illuminate\Support\Facades\Route;

Route::get('', [
    'as' => 'admin.dashboard',
    'uses' => 'AdminController@dashboard'
]);

Route::group(['prefix' => 'users'], function () {
    Route::get('{user_category}', [
        'as' => 'admin.users.index',
        'uses' => 'UserController@index'
    ]);

    Route::get('/disable/{id}', 'UserController@disable')->name('admin.users.disable');
    Route::get('/restore/{id}', 'UserController@restore')->name('admin.users.restore');

    // Route::resource('users', 'UserController')->names([
    //     'index' => 'admin.users.index',
    //     'show' => 'admin.users.show',
    //     'update' => 'admin.users.update',
    // ]);
});

Route::group(['prefix' => 'contests'], function () {
    Route::group(['prefix' => 'addons'], function () {
        Route::match(['get', 'post', 'put'], '{id?}', [
            'as' => 'admin.contests.addons.index',
            'uses' => 'ContestController@addons'
        ]);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::match(['get', 'post'], '', [
            'as' => 'admin.contests.categories.index',
            'uses' => 'ContestController@categories'
        ]);

        Route::match(['post', 'put', 'delete'], 'sub-category', [
            'as' => 'admin.contests.categories.sub-category',
            'uses' => 'ContestController@subCategory'
        ]);

        Route::match(['get', 'put'], '{id}', [
            'as' => 'admin.contests.categories.show',
            'uses' => 'ContestController@showCategory'
        ]);

        Route::delete('{id}', [
            'as' => 'admin.contests.categories.delete',
            'uses' => 'ContestController@deleteCategory'
        ]);
    });

    Route::post('/contest/dispute', 'ContestController@hold_contest')->name('admin.contests.dispute');
    Route::get('/contest/resolve/{contest}', 'ContestController@resolve_contest')->name('admin.contests.resolve');


    Route::resource('', 'ContestController')->names([
        'index' => 'admin.contests.index'
    ]);
});

Route::group(['prefix' => 'withdrawals'], function () {
    Route::get('approve-reject/{withdrawal}/{status}', [
        'as' => 'admin.withdrawals.approve-reject',
        'uses' => 'WithdrawalsController@approveReject'
    ]);

    Route::get('{status}', [
        'as' => 'admin.withdrawals',
        'uses' => 'WithdrawalsController@index'
    ]);
});

Route::group(['prefix' => 'offers'], function () {
    Route::group(['prefix' => 'addons'], function () {
        Route::match(['get', 'post', 'put'], '{id?}', [
            'as' => 'admin.offers.addons.index',
            'uses' => 'OfferController@addons'
        ]);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::match(['get', 'post'], '', [
            'as' => 'admin.offers.categories.index',
            'uses' => 'OfferController@categories'
        ]);

        Route::match(['post', 'put', 'delete'], 'sub-category', [
            'as' => 'admin.offers.categories.sub-category',
            'uses' => 'OfferController@subCategory'
        ]);

        Route::match(['get', 'put'], '{id}', [
            'as' => 'admin.offers.categories.show',
            'uses' => 'OfferController@showCategory'
        ]);

        Route::delete('{id}', [
            'as' => 'admin.offers.categories.delete',
            'uses' => 'OfferController@deleteCategory'
        ]);
    });

    Route::get('/project-manager', 'OfferController@project_manager_offers')->name('admin.offers.project-manager');
    Route::post('/project-manager/dispute', 'OfferController@hold_project_manager_offer')->name('admin.offers.project-manager.dispute');
    Route::get('/project-manager/resolve/{offer}', 'OfferController@resolve_project_manager_offer')->name('admin.offers.project-manager.resolve');
    Route::get('/freelancer', 'OfferController@freelancer_offers')->name('admin.offers.freelancer');
    Route::get('/freelancer/dispute', 'OfferController@hold_freelancer_offer')->name('admin.offers.freelancer.dispute');
    Route::get('/freelancer/resolve/{offer}', 'OfferController@resolve_freelancer_offer')->name('admin.offers.freelancer.resolve');


    Route::resource('', 'OfferController')->names([
        'index' => 'admin.offers.index'
    ]);
});

Route::delete('{id}', [
    'as' => 'admin.offers.categories.delete',
    'uses' => 'OfferController@deleteCategory'
]);

Route::prefix('admin/sliders')->group(function () {
    Route::get('/disable/{id}', 'SliderController@disable')->name('admin.sliders.disable');
    Route::get('/restore/{id}', 'SliderController@restore')->name('admin.sliders.restore');
    Route::get('/disabled', 'SliderController@disabled')->name('admin.sliders.disabled');
    // Route::get('/{link}', [CompaniesController::class, 'displayByLink'])->name('companies.single');
});

Route::resource('/sliders', 'SliderController')->names([
    'index' => 'admin.sliders.index',
    'create' => 'admin.sliders.create',
    'edit' => 'admin.sliders.edit',
    'update' => 'admin.sliders.update',
    'show' => 'admin.sliders.show',
    'delete' => 'admin.sliders.delete',
]);

Route::prefix('admin/testimonials
')->group(function () {
    Route::get('/disable/{id}', 'TestimonialController@disable')->name('admin.testimonials.disable');
    Route::get('/restore/{id}', 'TestimonialController@restore')->name('admin.testimonials.restore');
    Route::get('/disabled', 'TestimonialController@disabled')->name('admin.testimonials.disabled');
    // Route::get('/{link}', [CompaniesController::class, 'displayByLink'])->name('companies.single');
});

Route::resource('/testimonials', 'TestimonialController')->names([
    'index' => 'admin.testimonials.index',
    'create' => 'admin.testimonials.create',
    'store' => 'admin.testimonials.store',
    'edit' => 'admin.testimonials.edit',
    'update' => 'admin.testimonials.update',
    'show' => 'admin.testimonials.show',
    'delete' => 'admin.testimonials.delete',
]);

Route::resource('/newsletters', 'NewsletterController')->names([
    'index' => 'admin.newsletters.index',
    'create' => 'admin.newsletters.create',
    'store' => 'admin.newsletters.store',
    'edit' => 'admin.newsletters.edit',
    'update' => 'admin.newsletters.update',
    'show' => 'admin.newsletters.show',
    'delete' => 'admin.newsletters.delete',
]);

Route::resource('/admin-users', 'AdminUserController')->names([
    'index' => 'admin.admin-users.index',
    'create' => 'admin.admin-users.create',
    'store' => 'admin.admin-users.store',
    'edit' => 'admin.admin-users.edit',
    'update' => 'admin.admin-users.update',
    'show' => 'admin.admin-users.show',
    'delete' => 'admin.admin-users.delete',
]);