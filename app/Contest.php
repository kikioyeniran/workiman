<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $appends = [
        "possible_winner_count"
    ];

    protected $dates = [
        "ends_at",
        "ended_at"
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

    public function addons()
    {
        return $this->hasMany(ContestAddon::class);
    }

    public function getDesignersCountAttribute()
    {
        return ContestSubmission::where('contest_id', $this->id)->distinct()->count('user_id');
    }

    public function files()
    {
        return $this->hasMany(ContestFile::class);
    }

    public function tags()
    {
        return $this->hasMany(ContestTag::class);
    }

    public function getPossibleWinnersCountAttribute()
    {
        $count = 1;

        if (!is_null($this->second_place_prize)) {
            $count++;
        }

        if (!is_null($this->third_place_prize)) {
            $count++;
        }

        return $count;
    }
}
