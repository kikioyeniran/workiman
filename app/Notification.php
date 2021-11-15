<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contest_dispute(){
        return $this->belongsTo(ContestDispute::class, 'contest_dispute_id');
    }

    public function freelancer_offer_dispute(){
        return $this->belongsTo(FreelancerOfferDispute::class, 'freelancer_offer_dispute_id');
    }

    public function project_manager_offer_dispute(){
        return $this->belongsTo(ProjectManagerOfferDispute::class, 'project_manager_offer_dispute_id');
    }

    public function freelancer_offer(){
        return $this->belongsTo(FreelancerOffer::class, 'freelancer_offer_id');
    }

    public function project_manager_offer(){
        return $this->belongsTo(ProjectManagerOffer::class, 'project_manager_offer_id');
    }

    public function contest(){
        return $this->belongsTo(Contest::class, 'contest_id');
    }


}