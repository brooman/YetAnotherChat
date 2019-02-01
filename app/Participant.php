<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'channel_id', 'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function channel()
    {
        return $this->hasOne(Channel::class);
    }
}
