<?php

namespace App\Services\Api;

class LoginService
{
    private $classesRepository;

    public function __construct()
    {
    }

    public function login($request)
    {
        $loginData = $request->only(['email','password']);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    
}

