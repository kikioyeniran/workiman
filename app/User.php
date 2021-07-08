<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $appends = [
        'display_name'
    ];

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

    public function getConversationsAttribute()
    {
        return Conversation::where('user_1_id', $this->id)->orWhere('user_2_id', $this->id)->get();
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
            foreach ($this->withdrawals->where('status', '!=', 'rejected') as $withdrawal) {
                $balance -= ($withdrawal->amount / $withdrawal->fx_rate);
                // dd($withdrawal->amount);
                // dd($withdrawal->fx_rate);
            }
        }

        return $balance;
    }

    public function getCompletedContestSubmissionsAttribute()
    {
        return $this->contest_submissions->whereNotNull('position')->where('completed', true);
    }

    public function getCompletedOfferInterestsAttribute()
    {
        return ProjectManagerOfferInterest::where('user_id', $this->id)->where('assigned', true)->whereHas('offer', function ($offer) {
            $offer->where('completed', true);
        })->get();
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function getJobSuccessAttribute()
    {
        $job_success = 100;

        if ($this->freelancer) {
        }

        return $job_success;
    }

    public function getResponseRateAttribute()
    {
        $response_rate = 100;
        $user = $this;
        $hourly_percentage_score = 5;
        $total_conversations_counted = [];

        // Check for conversations this user is involved in that were not started by this user
        $conversations = Conversation::where(function ($query) use ($user) {
            $query->where('user_1_id', $user->id)->orWhere('user_2_id', $user->id);
        })->get();
        // ->whereHas('messages', function($query) use ($user) {
        //     // $query->where('user_id', '!=', $user->id);
        // });

        // var_dump($user->id);

        foreach ($conversations as $key => $conversation) {
            if ($conversation->messages->first()->user_id != $user->id) {
                $conversations->forget($key);
            } else {
                // Check time first message was sent
                $first_message_received_time = ConversationMessage::where('conversation_id', $conversation->id)->orderBy('created_at', 'asc')->where('user_id', '!=', $this->id)->first()->created_at;
                $first_message_response_time = \Carbon\Carbon::now();

                if ($first_message_response = ConversationMessage::where('conversation_id', $conversation->id)->orderBy('created_at', 'asc')->where('user_id', $this->id)->first()) {
                    $first_message_response_time = $first_message_response->created_at;
                }

                $diff_in_hours = $first_message_response_time->diffInHours($first_message_received_time);

                // var_dump($first_message_received_time);
                // var_dump("__________________________________");
                // var_dump($first_message_response_time);

                // $total_conversations_counted += 1;
                $total_conversations_counted[] = $diff_in_hours < 24 ? ($hourly_percentage_score * $diff_in_hours) : 100;
            }
        }

        $average_lag_time = array_sum($total_conversations_counted) / count($total_conversations_counted);

        // dd($average_lag_time);
        // dd($total_conversations_counted);

        return $response_rate - $average_lag_time;
    }
}