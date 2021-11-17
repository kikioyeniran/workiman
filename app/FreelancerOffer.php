<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOffer extends Model
{
    public function sub_category()
    {
        return $this->belongsTo(OfferSubCategory::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dispute(){
        return $this->hasOne(FreelancerOfferDispute::class);
    }

    public function hasDipute(){
        if(count($this->dispute) > 0){
            return true;
        } else{
            return false;
        }
    }

    public function interests()
    {
        return $this->hasMany(FreelancerOfferInterest::class);
    }
}