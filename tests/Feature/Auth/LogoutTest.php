<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guestCantLogout()
    {
        $this->json('POST', '/api/logout')
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function userCanLogout()
    {
        //Create user and generate token
        $user = factory(User::class)->make();
        $token = auth()->login($user);

        $token = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        $this->json('POST', '/api/logout', $token)
            ->assertStatus(200)
            ->assertJson([
            'message' => 'Successfully logged out',
        ]);
    }
}
