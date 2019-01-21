<?php

namespace YetAnotherChat;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
