<?php

namespace App\Services\Api;

use App\Repositories\Api\UsersRepository;

class UsersService
{
    private $usersRepository;

    public function __construct(
                                    UsersRepository $usersRepository
                               )
    {
        $this->usersRepository = $usersRepository;
    }

    public function users()
    {
        $users = $this->usersRepository->users();

        if($users !== null)
            return [
                'http_code' => 200,
                'return'   => $users
            ];
        else   
            return [
                'http_code' => 200,
                'return'   => ['message' => "Users not found"]
            ];
    }

    
}
