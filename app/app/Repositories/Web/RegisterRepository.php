<?php

namespace App\Repositories\Web;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Exception;

class RegisterRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $user = $this->user->where('email', $request->email)
                                ->first();
            
            if($user == null){
                
                $user = $this->user->create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'aproved'  => false,
                    'active'   => true
                ]);

                $user->attachRoles([$request->role]);

                DB::commit();

                return response(['Registro enviado para análise!'], 200);
            } else
                return response(['errors' => [
                                    'users' => [
                                        ['Usuário já cadastrado!']
                                    ]
                                ]], 400);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante o registro']
                                ]
                            ]], 500);
        }

    }
}
