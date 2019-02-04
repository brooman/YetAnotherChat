<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ChannelFactory;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function participantCanHaveARole()
    {
        $channel = app(ChannelFactory::class)->withParticipants(1)->create();

        $participant = $channel->participants[0];

        $participant->assignRole('owner');

        $this->assertTrue($participant->hasRole('owner'));
    }

    /**
     * @test
     */
    public function channelHasDefaultRoles()
    {
        $channel = app(ChannelFactory::class)->create();

        $this->assertTrue($channel->roles[0]->exists());
    }
}
