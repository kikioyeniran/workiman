<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversationMessage extends Model
{
    public $appends = [
        'created_at_diff'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}