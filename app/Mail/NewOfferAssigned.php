<?php

namespace App\Mail;

use App\Conversation;
use App\ProjectManagerOffer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewOfferAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $offer;
    public $project_manager;
    public $freelancer;
    public function __construct($id)
    {
        $this->offer = ProjectManagerOffer::find($id);
        $this->project_manager = User::find($this->offer->user_id);
        $this->freelancer = User::find($this->offer->offer_user_id);

        // Log::alert("new offer assigned conversation {$this->conversation}");
        // Log::alert("new offer assigned sender {$this->sender}");
        // Log::alert("new offer assigned freelancer {$this->freelancer}");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('offers@workiman.com')
            ->subject('New Project Offer Assigned')
            ->view('emails.new_offer_sent')
            ->with(['offer' => $this->offer, 'freelancer' => $this->freelancer, 'project_manager' => $this->project_manager]);
        return $mail;
    }
}