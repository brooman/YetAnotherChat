<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function loginRequiresValidCredentials()
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
    public function guestCanLogin()
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
