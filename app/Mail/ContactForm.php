<?php

namespace App\Mail;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contact_info;
    public function __construct($id)
    {
        $this->contact_info = Contact::find($id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('contact@thehospitalityqueen.com')
            ->subject('Contact Form')
            ->view('emails.contact')
            ->with(['contact' => $this->contact_info]);
        return $mail;
    }
}