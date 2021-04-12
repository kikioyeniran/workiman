<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public $with = [
        'messages',
        'user_1',
        'user_2',
    ];

    public $appends = [
        'last_message'
    ];

    public function getLastMessageAttribute()
    {
        return $this->messages->first();
    }

    public function messages()
    {
        return $this->hasMany(ConversationMessage::class)->with('user')->orderBy('created_at', 'desc');
    }

    public function user_1()
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }

    public function user_2()
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }
}