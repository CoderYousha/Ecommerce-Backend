<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    //Get Notifications Function
    public function read(Request $request){
        return $this->notificationService->getNotifications($request->per_page);
    }

    //Store FCM Token Function
    public function storeToken (Request $request){
        return $this->notificationService->saveToken($request);
    }
}
