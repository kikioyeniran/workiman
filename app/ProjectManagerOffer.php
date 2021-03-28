<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManagerOffer extends Model
{
    protected $with = ['user', 'offer_user', 'payment', 'files'];
    public function sub_category()
    {
        return $this->belongsTo(OfferSubCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer_user()
    {
        return $this->belongsTo(User::class, "offer_user_id");
    }

    public function payment()
    {
        return $this->hasOne(ProjectManagerOfferPayment::class);
    }

    public function skills()
    {
        return $this->hasMany(ProjectManagerOfferSkill::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectManagerOfferFile::class);
    }

    public function interests()
    {
        return $this->hasMany(ProjectManagerOfferInterest::class);
    }
}
