<?php

namespace App\Services;

use App\Transformers\Notifications\ClientNotificationsResponse;
use Illuminate\Support\Facades\Auth;

class NotificationService{
    public function getNotifications($perPage){
        $user = Auth::guard('user')->user();
        $notifications = $user->notifications()->paginate($perPage ?? 10);

        return success(ClientNotificationsResponse::format($notifications), 'Notifications inormation');
    }
}