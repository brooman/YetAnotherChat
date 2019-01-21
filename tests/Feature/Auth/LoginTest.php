<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use YetAnotherChat\User;

class LoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function login_needs_valid_credentials()
    {
        $data = [
            'email' => 'john.doe@example.org',
            'password' => 'secret',
        ];

        $this->json('POST', '/api/login', $data)
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    /**
     * @test
     */
    public function a_guest_can_login()
    {
        $user = factory(User::class)->create();

        $data = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $this->json('POST', '/api/login', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
