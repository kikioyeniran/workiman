<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestSubmissionComment extends Model
{
    public function submission()
    {
        return $this->belongsTo(ContestSubmission::class, 'contest_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
