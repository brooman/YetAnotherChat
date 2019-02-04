<?php

declare(strict_types=1);

namespace Tests\Feature\Messaging;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function user_can_create_a_channel()
    {
        $user = factory(User::class)->create();

        $data = [
            'name'  => $this->faker->company,
            'users' => [],
        ];

        $response = $this->actingAs($user)
                        ->json('POST', '/api/channel/create', $data)
                        ->assertStatus(200)
                        ->decodeResponseJson();

        $this->assertDatabaseHas('channels', [
            'name' => $data['name'],
        ]);

        $this->assertDatabaseHas('participants', [
            'channel_id' => $response['id'],
            'user_id'    => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function user_can_create_a_channel_with_others()
    {
        //Create owner and members
        $owner = factory(User::class)->create();
        $users = factory(User::class, 9)->create();

        $data = [
            'name'  => $this->faker->company,
            'users' => [],
        ];

        //Add members to $data array
        foreach ($users as $user) {
            array_push($data['users'], $user->id);
        }

        $response = $this->actingAs($owner)
                        ->json('POST', '/api/channel/create', $data)
                        ->assertStatus(200)
                        ->decodeResponseJson();

        //Check that channel was created
        $this->assertDatabaseHas('channels', [
            'name' => $data['name'],
        ]);

        //Check that owner is in participants list
        $this->assertDatabaseHas('participants', [
            'channel_id' => $response['id'],
            'user_id'    => $owner->id,
        ]);

        //Check that a random member was added
        $this->assertDatabaseHas('participants', [
            'channel_id' => $response['id'],
            'user_id'    => $users->random()->id,
        ]);
    }

    /**
     * @test
     */
    public function guest_cant_create_a_channel()
    {
        $data = [
            'name'  => $this->faker->company,
            'users' => [],
        ];

        $this->json('POST', '/api/channel/create', $data)
            ->assertStatus(401);
    }
}
