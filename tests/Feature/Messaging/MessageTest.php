<?php

namespace Tests\Feature\Messaging;

use Tests\TestCase;
use Tests\Setup\ConversationFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Conversation;
use App\Participant;
use App\User;
use App\Message;

class MessageTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_send_a_message()
    {
        $conversation = app(ConversationFactory::class)->withParticipants(1)->create();

        $user = $conversation->users->first();

        $data = [
            'conversation_id' => $conversation->id,
            'content' => $this->faker->paragraph,
        ];

        //Send request
        $this->actingAs($user)->json('POST', 'api/message/create', $data)
             ->assertStatus(200);

        //Check database
        $this->assertDatabaseHas('messages', [
            'user_id' => $user->id,
            'conversation_id' => $data['conversation_id'],
            'content' => $data['content'],
        ]);
    }

    /**
     * @test
     */
    public function user_needs_to_be_participant_to_send_message()
    {
        //Create a conversation
        $conversation = factory(Conversation::class)->create();

        //Create user
        $user = factory(User::class)->create();

        $data = [
            'conversation_id' => $conversation->id,
            'content' => $this->faker->paragraph,
        ];

        //Send request
        $this->actingAs($user)->json('POST', 'api/message/create', $data)
             ->assertStatus(401);

        $this->assertDatabaseMissing('messages', [
            'user_id' => $user->id,
            'conversation_id' => $data['conversation_id'],
            'content' => $data['content'],
        ]);
    }

    /**
     * @test
     */
    public function user_can_update_a_message()
    {
        //Create conversation for foreign key constraint
        $conversation = app(ConversationFactory::class)->withParticipants(1)
                        ->withMessages(true)
                        ->create();

        $user = $conversation->users->first();

        $data = [
            'message_id' => $user->messages->first()->id,
            'content' => $this->faker->paragraph
        ];

        //Send request
        $this->actingAs($user)
                ->json('POST', 'api/message/edit', $data)
                ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'id' => $data['message_id'],
            'content' => $data['content']
        ]);
    }

    /**
     * @test
     */
    public function user_can_delete_a_message()
    {
        //Create conversation for foreign key constraint
        $conversation = app(ConversationFactory::class)->withParticipants(1)->withMessages(true)->create();

        $user = $conversation->users->first();

        $data = [
            'message_id' => $user->messages->first()->id,
        ];

        //Send request
        $this->actingAs($user)
                ->json('POST', 'api/message/destroy', $data)
                ->assertStatus(200);

        $this->assertDatabaseMissing('messages', [
            'id' => $data['message_id']
        ]);
    }
}
