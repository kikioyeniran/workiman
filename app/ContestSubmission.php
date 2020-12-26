<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestSubmission extends Model
{
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function files()
    {
        return $this->hasMany(ContestSubmissionFile::class);
    }
}
