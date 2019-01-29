<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guest_can_register()
    {
        $attributes = [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->json('POST', 'api/register', $attributes)
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => $attributes['username'],
            'email' => $attributes['email'],
        ]);
    }
}
