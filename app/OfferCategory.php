<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferCategory extends Model
{
    public function offer_sub_categories()
    {
        return $this->hasMany(OfferSubCategory::class);
    }
}
