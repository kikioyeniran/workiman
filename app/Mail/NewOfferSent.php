<?php

namespace App\Mail;

use App\ProjectManagerOfferInterest;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOfferSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $offer;
    public $freelancer;
    public $project_manager;
    public function __construct($id)
    {
        $this->offer = ProjectManagerOfferInterest::find($id);
        $this->project_manager = User::find($this->offer->user_id);
        $this->freelancer = User::find($this->offer->offer_user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('offers@workiman.com')
            ->subject('New Project Offer')
            ->view('emails.new_offer_sent')
            ->with(['offer' => $this->offer, 'freelancer' => $this->freelancer, 'project_manager' => $this->project_manager]);
        return $mail;
    }
}