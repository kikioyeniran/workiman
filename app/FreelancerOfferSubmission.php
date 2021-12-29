<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferSubmission extends Model
{
    public function interest()
    {
        return $this->belongsTo(FreelancerOfferInterest::class, 'interest_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(FreelancerOfferSubmissionFile::class, 'offer_submission_id');
    }

    public function comments()
    {
        return $this->hasMany(FreelancerOfferSubmissionComment::class, 'offer_submission_id');
    }
}