<?php

namespace App\Services\Login;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Exception;

class LoginService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function access($request)
    {
        $user_ac = $this->user->where('email', $request->email)
                              ->first();

        if ($user_ac != null) {
            if (Hash::check($request->password, $user_ac->password)) {
                $credentials = $request->only('email', 'password');
                $tk = Auth::attempt($credentials);
                return response(['token' => $tk], 200);
            } else {
                return response(["message" => "Email ou senha incorretos"], 422);
            }
        }
    
    }
}
