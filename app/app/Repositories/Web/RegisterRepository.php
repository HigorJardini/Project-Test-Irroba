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

            $this->user->create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'aproved'  => false,
                'active'   => true
            ]);

            DB::commit();

            return response(['Registro enviado para análise!'], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['Erro durante o registro'], 500);
        }

    }
}
