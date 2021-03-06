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

    public function accept($user_id)
    {
        return $this->usersRepository->accept($user_id);
    }

    public function delete($user_id)
    {
        return $this->usersRepository->delete($user_id);
    }

    public function manageIndex()
    {
        $users = $this->usersRepository->manageIndex();

        foreach($users as $key => $user){

            $roles = [];

            foreach($user->roles as $role){
                $roles[] = $role->display_name;
            }
            
            $users[$key]->tags = implode(',',$roles);
        }

        return $users;
    }

    public function manageStore($request)
    {
        return $this->usersRepository->manageStore($request);
    }

    public function manageView($user_id)
    {
        return $this->usersRepository->manageView($user_id);
    }

    public function manageUpdate($request)
    {
        return $this->usersRepository->manageUpdate($request);
    }
}
