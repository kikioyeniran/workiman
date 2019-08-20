<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestCategory extends Model
{
    public function contest_sub_categories()
    {
        return $this->hasMany(ContestSubCategory::class);
    }
}
