<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $dates = [
        "ends_at"
    ];

    public function payment()
    {
        return $this->hasOne(ContestPayment::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(ContestSubCategory::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(ContestSubmission::class);
    }
}
