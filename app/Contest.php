<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $appends = [
        "possible_winners_count", "prize_money"
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

    public function getPrizeMoneyAttribute()
    {
        $prize_money = [];
        $total_amount = $this->budget;
        $system_commission = .2 * $total_amount; // 20%
        $amount_to_be_shared = $total_amount - $system_commission;

        switch ($this->possible_winners_count) {
            case 3:
                $first_place_prize = (doubleval($this->first_place_prize) / 100) * $amount_to_be_shared;
                $second_place_prize = (doubleval($this->second_place_prize) / 100) * $amount_to_be_shared;

                $third_place_prize = $amount_to_be_shared - $first_place_prize - $second_place_prize;

                $prize_money[1] = $first_place_prize;
                $prize_money[2] = $second_place_prize;
                $prize_money[3] = $third_place_prize;
                break;
            case 2:
                $first_place_prize = doubleval($this->first_place_prize);
                $second_place_prize = 100 - $first_place_prize;
                $prize_money[2] = $second_place_prize;
                $prize_money[1] = $second_place_prize;
                break;
            default:
                $prize_money[1] = $amount_to_be_shared;
                break;
        }

        return $prize_money;
    }
}
