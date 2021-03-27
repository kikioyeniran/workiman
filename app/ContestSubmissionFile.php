<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestSubmissionFile extends Model
{
    public function submission()
    {
        return $this->belongsTo(ContestSubmission::class, "contest_submission_id");
    }

    public function comments()
    {
        return $this->hasMany(ContestSubmissionFileComment::class, 'file_id');
    }
}
