<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestSubCategory extends Model
{
    public function contest_category()
    {
        return $this->belongsTo(ContestCategory::class);
    }

    public function contests()
    {
        // return $this->hasMany(Contest::class);
    }
}
