<?php

namespace App\Transformers\Notifications;

use App\Transformers\Pagination\PaginationResponse;

class ClientNotificationsResponse {
    public static function format ($notifications) {
        $data = ['notifications' => []];

        foreach ($notifications as $notification){
            $data['notifications'][] = [
                'id' => $notification->id,
                'name_en' => $notification->name_en,
                'name_ar' => $notification->name_ar,
                'description_en' => $notification->description_en,
                'description_ar' => $notification->description_ar,
                'type' => $notification->type,
                'link' => $notification->link,
            ];
        }

        $data['pagination'] = PaginationResponse::format($notifications);

        return  $data;
    }
}