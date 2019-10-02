<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferSubCategory extends Model
{
    public function offer_category()
    {
        return $this->belongsTo(OfferCategory::class);
    }

    public function offers()
    {
        // return $this->hasMany(Offer::class);
    }
}
