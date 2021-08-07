<?php

namespace App\Services\Login;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Web\LoginRepository;

use Exception;

class LoginService
{
    private $loginRepository;

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function access($request)
    {
        $user_ac = $this->loginRepository->access($request->email);

        if ($user_ac != null) {
            if(!$user_ac->aproved)
                return response(["message" => "Usuário aguardando aprovação de registro."], 422);
            else if(!$user_ac->active)
                return response(["message" => "Usuário desativado."], 422);
            else {
                if (Hash::check($request->password, $user_ac->password)) {
                    $credentials = $request->only('email', 'password');
                    $tk = Auth::attempt($credentials);
                    return response(['token' => $tk], 200);
                } else {
                    return response(["message" => "Email ou senha incorretos."], 422);
                }
            }
        }
    }
}
