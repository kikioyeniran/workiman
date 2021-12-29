<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferSubmissionFileComment extends Model
{
    public function offer_submission_file()
    {
        return $this->belongsTo(FreelancerOfferSubmissionFile::class, 'file_id');
    }
}