<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function CreateJWTAuthHeader($user = null)
    {
        if ($user) {
            $token = JWTAuth::fromUser($user);
            $headers['Authorization'] = 'Bearer '.$token;
        }

        return $headers;
    }
}
