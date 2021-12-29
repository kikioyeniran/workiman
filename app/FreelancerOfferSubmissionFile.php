<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferSubmissionFile extends Model
{
    public function submission()
    {
        return $this->belongsTo(FreelancerOfferSubmission::class, "offer_submission_id");
    }

    public function comments()
    {
        return $this->hasMany(FreelancerOfferSubmissionFileComment::class, 'file_id');
    }
}