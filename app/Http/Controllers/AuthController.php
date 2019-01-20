<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //Validate
        $request->validate([
            'username' => 'required|string|max:32|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //Create user object
        $user = new User([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Store user in database
        $user->save();

        //Create Auth token
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'), 201);
    }

    public function login(Request $request)
    {
    }

    public function logout(Request $request)
    {
    }
}
