<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferSubmissionComment extends Model
{
    public function submission()
    {
        return $this->belongsTo(FreelancerOfferSubmission::class, 'offer_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}