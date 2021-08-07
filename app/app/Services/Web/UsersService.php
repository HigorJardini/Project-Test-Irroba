<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Web\UsersRepository;

use Exception;

class UsersService
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index()
    {
        $users = $this->usersRepository->index();

        foreach($users as $key => $user){

            $roles = [];

            foreach($user->roles as $role){
                $roles[] = $role->display_name;
            }
            
            $users[$key]->tags = implode(',',$roles);
        }

        return $users;
    }
}
