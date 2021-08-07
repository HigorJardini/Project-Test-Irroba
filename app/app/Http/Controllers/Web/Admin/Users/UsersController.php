<?php

namespace App\Http\Controllers\Web\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Web\UsersService;

class UsersController extends Controller
{
    private $usersService;

    public function __construct(
        UsersService $usersService
    )
    {
        $this->middleware('auth');
        $this->usersService = $usersService;
    }
    
    public function index()
    {   
        $users = $this->usersService->index();
        return view('web.pages.users.aproved', compact(['users']));
    }
}
