<?php

namespace Tests\Feature\Messaging;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use YetAnotherChat\User;

class ConversationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_create_a_conversation()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $data = [
            'name' => $this->faker->company,
            'users' => [],
        ];

        $response = $this->json('POST', '/api/conversation/create', $data, $this->createJWTAuthHeader($user))
                        ->assertStatus(200)
                        ->decodeResponseJson();

        $this->assertDatabaseHas('conversations', [
            'name' => $data['name'],
        ]);

        $this->assertDatabaseHas('participants', [
            'conversation_id' => $response['id'],
            'user_id' => $user->id,
        ]);
    }
}
