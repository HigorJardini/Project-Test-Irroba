<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestRegister;
use App\Http\Requests\RequestUpdateUser;

use App\Services\Web\NotificationService;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(
        NotificationService $notificationService
    )
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }
    
    public function notifications()
    {   
        $ntc = $this->notificationService->notifications();
        return response($ntc,200);
    }

    public function notificationsClose($warning_id)
    {   
        return $this->notificationService->notificationsClose($warning_id);
    }
}
