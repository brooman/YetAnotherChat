<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'channel_id', 'participant_id', 'content',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
