<?php

namespace YetAnotherChat;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'conversation_id', 'user_id',
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function conversation()
    {
        $this->hasOne(Conversation::class);
    }
}
