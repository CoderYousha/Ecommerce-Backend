<?php

namespace App\Services;

use App\Transformers\Notifications\ClientNotificationsResponse;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getNotifications($perPage)
    {
        $user = Auth::guard('user')->user();
        $notifications = $user->notifications()->paginate($perPage ?? 10);

        return success(ClientNotificationsResponse::format($notifications), 'Notifications inormation');
    }

    public function saveToken($request)
    {
        $user = Auth::guard('user')->user();
        $request->validate(['fcm_token' => 'required|string']);

        $user->update(['fcm_token' => $request->fcm_token], []);

        return response()->json(['message' => 'FCM Token saved successfully']);
    }
}
