<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManagerOfferInterest extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(ProjectManagerOffer::class, 'project_manager_offer_id');
    }
}
