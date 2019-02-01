<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'participants', 'channel_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
