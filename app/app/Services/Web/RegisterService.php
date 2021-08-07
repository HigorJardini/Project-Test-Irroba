<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Web\RegisterRepository;

use Exception;

class RegisterService
{
    private $registerRepository;

    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function create($request)
    {
        return $this->registerRepository->create($request);
    }
}
