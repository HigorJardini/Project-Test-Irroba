<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Web\NotificationRepository;

use Exception;

class NotificationService
{
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function notifications()
    {
        return $this->notificationRepository->notifications();;
    }

    public function notificationsClose($warning_id)
    {
        return $this->notificationRepository->notificationsClose($warning_id);
    }
    
}
