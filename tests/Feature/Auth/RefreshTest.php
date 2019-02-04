<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    /**
     * @test
     */
    public function a_logged_in_user_can_refresh_token()
    {
        $user = factory(User::class)->make();
        $token = auth()->login($user);

        $token = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        $this->json('POST', '/api/login/refresh', $token)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
