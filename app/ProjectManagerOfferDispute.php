<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManagerOfferDispute extends Model
{
    public function project_manager_offer(){
        return $this->belongsTo(ProjectManagerOffer::class, 'project_manager_offer_id');
    }
}