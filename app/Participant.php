<?php

declare(strict_types=1);

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [
        'channel_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function channel()
    {
        return $this->hasOne(Channel::class);
    }
}
