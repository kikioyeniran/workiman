<?php

namespace App\Mail;

use App\ConversationMessage;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageChat extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $conversation;
    public $receiver;
    public $sender;
    public function __construct($id, $receiver)
    {
        $this->reciever = User::find($receiver);
        $this->conversation = ConversationMessage::find($id);
        $this->sender = User::find($this->conversation->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $mail = $this->from('messages@workiman.com')
        //     ->subject('New Message')
        //     ->view('emails.new_message_chat')
        //     ->with(['conversation' => $this->conversation, 'reciever' => $this->reciever, 'sender' => $this->sender]);
        // return $mail;

        $mail = $this->from('messages@workiman.com')
            ->subject('New Message')
            ->view('emails.new_message_chat')
            ->with(['conversation' => $this->conversation, 'reciever' => $this->reciever, 'sender' => $this->sender]);
        return $mail;
    }
}