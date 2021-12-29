<?php

namespace App\Mail;

use App\FreelancerOfferSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOfferSubmission extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $submission;
    public $offer;
    public function __construct($id)
    {
        $this->submission = FreelancerOfferSubmission::find($id);
        $this->offer = $this->submission->offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('offers@workiman.com')
            ->subject('New Offer Submission')
            ->view('emails.new_offer_submission')
            ->with(['offer' => $this->offer, 'submission' => $this->submission]);
        return $mail;
    }
}