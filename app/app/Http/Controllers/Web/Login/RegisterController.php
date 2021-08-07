<?php

namespace App\Http\Controllers\Web\Login;

use App\Http\Requests\RequestRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Services\Web\RegisterService;

class RegisterController extends Controller
{
    private $registerService;


    public function __construct(RegisterService $registerService)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->registerService = $registerService;
    }

    public function index()
    {
        return view('web.pages.register');
    }

    public function create(RequestRegister $request)
    {
        return $this->registerService->create($request);
    }
   
}
