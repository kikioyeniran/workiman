<?php

namespace App\Mail;

use App\Contest;
use App\ContestDispute;
use App\FreelancerOffer;
use App\FreelancerOfferDispute;
use App\ProjectManagerOffer;
use App\ProjectManagerOfferDispute;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisputeNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $dispute;
    public $type;
    public $sender;
    public $receiver;
    public function __construct($id, $dispute_type, $sender, $receiver)
    {
        $this->type = $dispute_type;
        $this->sender = User::find($sender);
        $this->receiver = User::find($receiver);
        if($dispute_type == 'project_manager_offer'){
            $this->dispute = ProjectManagerOfferDispute::find($id);
        }elseif($dispute_type == 'freelancer_offer'){
            $this->dispute = FreelancerOfferDispute::find($id);
        }else{
            $this->dispute = ContestDispute::find($id);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('disputes@workiman.com')
            ->subject('Project Dispute')
            ->view('emails.dispute_notification')
            ->with(['dispute' => $this->dispute, 'type' => $this->type, 'sender' => $this->sender, 'receiver' => $this->receiver]);
        return $mail;
    }
}