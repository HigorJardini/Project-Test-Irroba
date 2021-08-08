<?php

namespace App\Repositories\Api;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Laratrust;

class UsersRepository
{

    private $user;

    public function __construct(
                                   User $user
                               )
    {
        $this->user = $user;
    }

    public function users()
    {
        try {

                return $this->user->with('roles')
                                  ->select('id', 'name', 'email')
                                  ->selectRaw("IF(active, 'Ativo', 'Inativo') as status")
                                  ->selectRaw("DATE_FORMAT(created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                                  ->where('aproved', true)
                                  ->get()
                                  ->toArray();

        } catch (\Throwable $th) {
            return null;
        }
        
    }
    
}
