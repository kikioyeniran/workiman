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

    public function payments()
    {
        return $this->hasMany(FreelancerOfferPayment::class);
    }

    public function getValidInterestsAttribute(){
        // $interests = $this->interests->where('is_paid', true)->get();
        $interests = FreelancerOfferInterest::where('freelancer_offer_id', $this->id)->where('is_paid', true)->get();
        return $interests;
    }

    public function hasValidInterest($user){
        $interest = FreelancerOfferInterest::where('freelancer_offer_id', $this->id)->where('user_id', $user)->where('is_paid', true)->first();
        return $interest;
    }
}