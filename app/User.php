<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getDisplayNameAttribute()
    {
        return trim($this->full_name) != "" ? $this->full_name : $this->username;
    }

    public function contests()
    {
        return $this->hasMany(Contest::class);
    }

    public function getPaidContestsAttribute()
    {
        return $this->hasMany(Contest::class)->whereHas('payment');
    }

    public function getCountryAttribute()
    {
        return Country::where('id', $this->country_id)->first();
    }

    public function freelancer_profile()
    {
        return $this->hasOne(Freelancer::class);
    }

    public function payment_method()
    {
        return $this->hasOne(PaymentMethod::class);
    }

    public function project_manager_offers()
    {
        return $this->hasMany(ProjectManagerOffer::class)->with(['sub_category.offer_category', 'user']);
    }

    public function getPaidProjectManagerOffersAttribute()
    {
        return $this->hasMany(ProjectManagerOffer::class)->with('sub_category.offer_category')->whereHas('payment');
    }

    public function freelancer_offers()
    {
        return $this->hasMany(FreelancerOffer::class)->with(['sub_category.offer_category', 'user']);
    }

    public function contest_submissions()
    {
        return $this->hasMany(ContestSubmission::class);
    }

    public function project_manager_offer_interests()
    {
        return $this->hasMany(ProjectManagerOfferInterest::class);
    }

    public function getFreelancerRankAttribute()
    {
        $rank = 0;

        if ($this->freelancer) {
            // Calculate Rank
            $rank = 1;
        }

        return $rank;
    }

    public function getWalletBalanceAttribute()
    {
        $balance = 0;

        if ($this->freelancer) {
            // Add total income from contest submissions
            foreach ($this->completed_contest_submissions as $completed_contest_submission) {
                $balance += $completed_contest_submission->contest->prize_money[$completed_contest_submission->position];
            }

            // dd($this->completed_offers[0]);
            // Add total income from completed offers
            foreach ($this->completed_offer_interests as $completed_offer_interest) {
                $balance += $completed_offer_interest->offer->prize_money;
            }

            // Subtract withdrawals
        }

        return $balance;
    }

    public function getCompletedContestSubmissionsAttribute()
    {
        return $this->contest_submissions->whereNotNull('position')->where('completed', true);
    }

    public function getCompletedOfferInterestsAttribute()
    {
        return ProjectManagerOfferInterest::where('user_id', $this->id)->where('assigned', true)->whereHas('offer', function($offer) {
            $offer->where('completed', true);
        })->get();
    }
}
