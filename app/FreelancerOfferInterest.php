<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerOfferInterest extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(FreelancerOffer::class, 'freelancer_offer_id');
    }

    public function submissions(){
        return $this->hasMany(FreelancerOfferSubmission::class, 'interest_id');
    }
}