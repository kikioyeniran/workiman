<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManagerOffer extends Model
{
    public function sub_category()
    {
        return $this->belongsTo(OfferSubCategory::class);
    }
}
