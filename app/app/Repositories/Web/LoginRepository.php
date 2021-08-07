<?php

namespace App\Repositories\Web;

use App\Models\User;

use Exception;

class LoginRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function access($email)
    {
        return $this->user->where('email', $email)
                              ->first();
    }
}
