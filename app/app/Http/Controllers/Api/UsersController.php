<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use App\Services\Api\UsersService;

class UsersController extends Controller
{

    private $usersService;

    public function __construct(
                                    UsersService $usersService
                               )
    {
        $this->usersService = $usersService;
    }

    public function users()
    {
        $users = $this->usersService->users();
        return response()->json($users['return'], $users['http_code']);
    }

    
}
