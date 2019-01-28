<?php

namespace App;

use App\User;
use App\Message;
use App\Participant;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'participants', 'conversation_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
