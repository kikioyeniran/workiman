<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestDispute extends Model
{
    public function contest(){
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}