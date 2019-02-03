<?php

declare(strict_types=1);

namespace Tests\Feature\Messaging;

use App\Channel;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ChannelFactory;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function participant_can_send_a_message()
    {
        $channel = app(ChannelFactory::class)
                    ->withParticipants(1)
                    ->create();

        $user = $channel->participants[0]->user;

        $data = [
            'channel_id' => $channel->id,
            'content'    => $this->faker->paragraph,
        ];

        //Send request
        $this->actingAs($user)
            ->json('POST', 'api/message/create', $data)
            ->assertStatus(200);

        //Check database
        $this->assertDatabaseHas('messages', [
            'participant_id' => $channel->participants[0]->id,
            'channel_id'     => $data['channel_id'],
            'content'        => $data['content'],
        ]);
    }

    /**
     * @test
     */
    public function non_participant_cant_send_a_message()
    {
        //Create a channel
        $channel = app(ChannelFactory::class)->create();

        //Create user
        $user = factory(User::class)->create();

        $data = [
            'channel_id' => $channel->id,
            'content'    => $this->faker->paragraph,
        ];

        //Send request
        $this->actingAs($user)
            ->json('POST', 'api/message/create', $data)
            ->assertStatus(401);

        $this->assertDatabaseMissing('messages', [
            'channel_id' => $data['channel_id'],
            'content'    => $data['content'],
        ]);
    }

    /**
     * @test
     */
    public function participant_can_update_a_message()
    {
        //Create channel for foreign key constraint
        $channel = app(ChannelFactory::class)
                    ->withParticipants(1)
                    ->withMessages(true)
                    ->create();

        $user = $channel->participants[0]->user;

        $data = [
            'message_id' => $channel->participants[0]->messages[0]->id,
            'content'    => $this->faker->paragraph,
        ];

        //Send request
        $this->actingAs($user)
            ->json('POST', 'api/message/edit', $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'id'      => $data['message_id'],
            'content' => $data['content'],
        ]);
    }

    /**
     * @test
     */
    public function participant_can_delete_a_message()
    {
        //Create channel for foreign key constraint
        $channel = app(ChannelFactory::class)
                    ->withParticipants(1)
                    ->withMessages(true)
                    ->create();

        $user = $channel->participants[0]->user;

        $data = [
            'message_id' => $channel->participants[0]->messages[0]->id,
        ];

        //Send request
        $this->actingAs($user)
            ->json('POST', 'api/message/destroy', $data)
            ->assertStatus(200);

        $this->assertDatabaseMissing('messages', [
            'id' => $data['message_id'],
        ]);
    }
}
