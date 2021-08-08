<?php

namespace App\Http\Controllers\Web\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestRegister;
use App\Http\Requests\RequestUpdateUser;

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

    public function accept($user_id)
    {   
        return $this->usersService->accept($user_id);
    }

    public function delete($user_id)
    {   
        return $this->usersService->delete($user_id);
    }

    public function manageIndex()
    {   
        $users = $this->usersService->manageIndex();
        return view('web.pages.users.manage', compact(['users']));
    }

    public function manageCreate()
    {
        $type = 'create';
        return view('web.pages.users.updateOrCreate', compact('type'));
    }

    public function manageStore(RequestRegister $request)
    {
        $result = $this->usersService->manageStore($request);
        $type = 'create';
        return view('web.pages.users.updateOrCreate', compact('type','result'));
    }

    public function manageView($user_id)
    {
        $users = $this->usersService->manageView($user_id);
        $type = 'edit';
        return view('web.pages.users.updateOrCreate', compact('type'))->with([
            'users' => $users
        ]);
    }

    public function manageUpdate(RequestUpdateUser $request)
    {
        $result = $this->usersService->manageUpdate($request);
        $users  = $this->usersService->manageView($request->user_id);
        $type   = 'edit';
        return view('web.pages.users.updateOrCreate', compact('type','result'))->with([
            'users' => $users
        ]);
        
    }
}
