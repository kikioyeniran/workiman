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

    public function comments()
    {
        return $this->hasMany(ProjectManagerOfferComment::class);
    }

    public function getPrizeMoneyAttribute()
    {
        $total_amount = $this->budget;
        $system_commission = .2 * $total_amount; // 20%
        $prize_money = $total_amount - $system_commission;

        // switch ($this->possible_winners_count) {
        //     case 3:
        //         $first_place_prize = (doubleval($this->first_place_prize) / 100) * $amount_to_be_shared;
        //         $second_place_prize = (doubleval($this->second_place_prize) / 100) * $amount_to_be_shared;

        //         $third_place_prize = $amount_to_be_shared - $first_place_prize - $second_place_prize;

        //         $prize_money[1] = $first_place_prize;
        //         $prize_money[2] = $second_place_prize;
        //         $prize_money[3] = $third_place_prize;
        //         break;
        //     case 2:
        //         $first_place_prize = doubleval($this->first_place_prize);
        //         $second_place_prize = 100 - $first_place_prize;
        //         $prize_money[2] = $second_place_prize;
        //         $prize_money[1] = $second_place_prize;
        //         break;
        //     default:
        //         $prize_money[1] = $amount_to_be_shared;
        //         break;
        // }

        return $prize_money;
    }
}
