<?php

namespace App;

use App\Permission;
use App\Participant;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'channel_id'
    ];

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'participant_roles');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_permissions');
    }
}
