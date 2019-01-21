<?php

namespace Tests;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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
