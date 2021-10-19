<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferDispute extends Model
{
    public function freelancer_offer(){
        return $this->belongsTo(FreelancerOffer::class, 'freelancer_offer_id');
    }
}