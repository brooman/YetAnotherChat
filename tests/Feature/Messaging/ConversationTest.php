<?php

namespace Tests\Feature\Messaging;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ConversationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_create_a_conversation()
    {
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

    /**
     * @test
     */
    public function a_user_can_create_a_conversation_with_others()
    {
        //Create owner and members
        $owner = factory(User::class)->create();
        $users = factory(User::class, 9)->create();

        $data = [
            'name' => $this->faker->company,
            'users' => [],
        ];

        //Add members to $data array
        foreach ($users as $user) {
            array_push($data['users'], $user->id);
        }

        $response = $this->json('POST', '/api/conversation/create', $data, $this->createJWTAuthHeader($owner))
                        ->assertStatus(200)
                        ->decodeResponseJson();

        //Check that conversation was created
        $this->assertDatabaseHas('conversations', [
            'name' => $data['name'],
        ]);

        //Check that owner is in participants list
        $this->assertDatabaseHas('participants', [
            'conversation_id' => $response['id'],
            'user_id' => $owner->id,
        ]);

        //Check that a random member was added
        $this->assertDatabaseHas('participants', [
            'conversation_id' => $response['id'],
            'user_id' => $users->random()->id,
        ]);
    }
}
