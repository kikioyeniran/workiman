<?php

namespace App\Mail;

use App\ContestSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContestSubmission extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $submission;
    public $contest;
    public function __construct($id)
    {
        $this->submission = ContestSubmission::find($id);
        $this->contest = $this->submission->contest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('contests@workiman.com')
            ->subject('New Contest Submission')
            ->view('emails.new_contest_submission')
            ->with(['contest' => $this->contest, 'submission' => $this->submission]);
        return $mail;
    }
}