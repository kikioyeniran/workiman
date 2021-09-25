<?php

namespace App\Mail;

use App\Conversation;
use App\ProjectManagerOffer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOfferAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sender;
    public $reciever;
    public $conversation;
    public function __construct($id)
    {
        $this->conversation = Conversation::find($id);
        $this->sender = User::find($this->offer->user_id);
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