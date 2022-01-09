<?php

namespace App\Mail;

use App\FreelancerOfferInterest;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FreelancerOfferInterestResponse extends Mailable
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
    public $response;
    public function __construct($id, $response)
    {
        $this->response = $response;
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
            ->subject('Freelancer Offer Interest ' . $this->response)
            ->view('emails.new_interest_response')
            ->with(['interest' => $this->interest, 'freelancer' => $this->freelancer, 'project_manager' => $this->project_manager, 'response' => $this->response]);
        return $mail;
    }
}