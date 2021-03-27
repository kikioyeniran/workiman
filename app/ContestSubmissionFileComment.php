<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestSubmissionFileComment extends Model
{
    public function contest_submission_file()
    {
        return $this->belongsTo(ContestSubmissionFile::class, 'file_id');
    }
}
