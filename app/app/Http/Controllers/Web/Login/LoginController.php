<?php

namespace App\Http\Controllers\Web\Login;

use App\Http\Requests\RequestLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Services\Web\LoginService;

class LoginController extends Controller
{
    private $loginService;


    public function __construct(LoginService $loginService)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->loginService = $loginService;
    }

    public function index()
    {
        return view('web.pages.login');
    }

    public function access(RequestLogin $request)
    {
        $login = $this->loginService->access($request);
    
        if ($login->status() != 200){
            return back()->withInput()->withErrors(json_decode($login->content()));
        }else{
            return redirect()->route('admin.dashboard');
        }
    }

     /**
     * Logout user and redirect to ...
     *
     * @return redirect
     */
    public function logout()
    {   
        Auth::logout();
        return redirect()->route('login.index');
    }
}
