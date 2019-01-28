<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
