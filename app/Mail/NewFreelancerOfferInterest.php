<?php

namespace App\Mail;

use App\FreelancerOfferInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\ProjectManagerOfferInterest;
use App\User;

class NewFreelancerOfferInterest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $interest;
    public $freelancer;
    public $project_manager;
    public function __construct($id)
    {
        $this->interest = FreelancerOfferInterest::find($id);
        $this->project_manager = User::find($this->interest->user->id);
        $this->freelancer = User::find($this->interest->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('offers@workiman.com')
            ->subject('New Project Offer Interest')
            ->view('emails.new_interest_notification')
            ->with(['interest' => $this->interest, 'freelancer' => $this->freelancer, 'project_manager' => $this->project_manager]);
        return $mail;
    }
}