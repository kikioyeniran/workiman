<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => '\App\Http\Controllers\Account'
], function () {
    Route::group([
        'middleware' => 'freelancer',
    ], function () {
        Route::get('entries', [
            'as' => 'contest.entries',
            'uses' => 'ContestController@entries'
        ]);
    });

    Route::group([
        'middleware' => 'project-manager',
    ], function () {
        Route::match(['get', 'post'], 'payment/{contest}', [
            'as' => 'contests.payment',
            'uses' => 'ContestController@payment'
        ]);

        Route::post('images', [
            'as' => 'contests.images',
            'uses' => 'ContestController@images'
        ]);

        Route::resource('', 'ContestController')->only([
            'create',
            'store',
        ])->names([
            'create' => 'contests.create',
            'store' => 'contests.store',
        ]);

        Route::get("{slug}/submissions", [
            "as" => "contests.submissions",
            "uses" => "ContestController@submissions"
        ]);

        Route::get("extend-contest", [
            "as" => "contests.extend-contest",
            "uses" => "ContestController@extend_contest"
        ]);

        // Route::post("{slug}/submission/{submission_file}/comment", [
        //     "as" => "contests.submission.file-comment",
        //     "uses" => "ContestController@submissionComment"
        // ]);

        Route::get("{slug}/submission/{submission}/completed", [
            "as" => "contests.submission-completed",
            "uses" => "ContestController@submissionCompleted",
        ]);

        Route::get("{slug}/submission/{submission}/download-files", [
            "as" => "contests.submission.download-files",
            "uses" => "ContestController@downloadSubmissionFiles"
        ]);

        Route::post("{slug}/winners", [
            "as" => "contests.winners",
            "uses" => "ContestController@winners"
        ]);
    });

    Route::post("{slug}/submit", [
        "as" => "contests.submit",
        "uses" => "ContestController@submit"
    ]);

    Route::get("{slug}/submissions/{submission}", [
        "as" => "contests.submission",
        "uses" => "ContestController@submission",
        "middleware" => "account"
    ]);

    Route::post('{slug}/comment/submissions/{submission}', [
        'as' => 'contests.submission.comment',
        'uses' => 'ContestController@submissionComment'
    ]);

    Route::get('{slug}/submissions/{submission}/{comment}/download-file', [
        'as' => 'contests.submission.comment.download-file',
        'uses' => 'ContestController@downloadSubmissionRawFile',
        'middleware' => 'account',
    ]);
});

Route::get("", [
    "as" => "contests.index",
    "uses" => "ContestController@index"
]);

Route::post("filter", [
    "as" => "contests.filter",
    "uses" => "ContestController@filter"
]);

Route::get("tags/{tag}", [
    "as" => "contests.tag",
    "uses" => "ContestController@tag"
]);

Route::get("user/{username}", [
    "as" => "contests.user",
    "uses" => "ContestController@user"
]);

// Route::get("user/{username}/", [
//     "as" => "contests.user.pending",
//     "uses" => "ContestController@user_pending"
// ]);

// Route::get("user/{username}/active", [
//     "as" => "contests.user.active",
//     "uses" => "ContestController@user_active"
// ]);

// Route::get("user/{username}/inactive", [
//     "as" => "contests.user.inactive",
//     "uses" => "ContestController@user_inactive"
// ]);

// Route::get("user/{username}/completed", [
//     "as" => "contests.user.completed",
//     "uses" => "ContestController@user_completed"
// ]);

Route::get("{slug}", [
    "as" => "contests.show",
    "uses" => "ContestController@show"
]);