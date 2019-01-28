<?php

namespace Tests\Feature\Messaging;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Conversation;
use App\Participant;
use App\User;

class MessageTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_send_a_message()
    {
        $this->withoutExceptionHandling();

        //Create a conversation
        $conversation = factory(Conversation::class)->create();

        //Create participants
        $participants = factory(Participant::class, 10)->create([
            'conversation_id' => $conversation->id,
        ]);

        //Get users with id = 1, Returns collection(?)
        $user = User::find($participants->first()->user_id);

        $data = [
            'conversation_id' => $conversation->id,
            'content' => $this->faker->paragraph,
        ];

        //Send request
        $this->json('POST', 'api/message/create', $data, $this->CreateJWTAuthHeader($user->first()))
             ->assertStatus(200);

        //Check database
        $this->assertDatabaseHas('messages', [
            'user_id' => $user->first()->id,
            'conversation_id' => $data['conversation_id'],
            'content' => $data['content'],
        ]);
    }
}
