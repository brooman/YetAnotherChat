<?php

namespace App\Observers;

use App\Role;
use App\Channel;

class ChannelObserver
{
    //Register default roles
    public function created(Channel $channel)
    {
        $roles = [
            Role::create([
                'name' => 'owner',
                'channel_id' => $channel->id,
            ]),
            Role::create([
                'name' => 'moderator',
                'channel_id' => $channel->id,
            ]),
            Role::create([
                'name' => 'member',
                'channel_id' => $channel->id,
            ]),
        ];

        foreach ($roles as $role) {
            $channel->roles()->save($role);
        }
    }
}
