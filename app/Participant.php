<?php

declare(strict_types=1);

namespace App;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasRoles;

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
        return $this->belongsTo(Channel::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'participant_roles');
    }
}
