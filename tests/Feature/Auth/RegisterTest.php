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
    public function a_guest_can_register()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->json('POST', 'api/register', $attributes);

        $this->assertDatabaseHas('users', [
            'username' => $attributes['username'],
            'email' => $attributes['email'],
        ]);
    }
}