<?php

namespace App\Repositories\Web;

use App\Models\User;

use Exception;

class UsersRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try {

            return $this->user->with('roles')
                              ->select('id', 'name', 'email')
                              ->selectRaw("DATE_FORMAT(created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                              ->where('aproved', false)
                              ->paginate(20);

        } catch (\Throwable $th) {
            dd($th);
            return response('', 500);
        }
    }
}
