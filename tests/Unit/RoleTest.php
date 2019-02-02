<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Setup\ChannelFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function participant_can_have_a_role()
    {
        $channel = app(ChannelFactory::class)->withParticipants(1)->create();

        $participant = $channel->participants[0];

        $role = Role::create(['name' => 'admin']);

        $participant->assignRole('admin');

        $this->assertTrue($participant->hasRole('admin'));
    }
}
