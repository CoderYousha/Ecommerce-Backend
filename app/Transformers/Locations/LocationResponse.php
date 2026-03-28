<?php

namespace App\Transformers\Locations;

use App\Transformers\Users\UserResponse;

class LocationResponse {
    public static function format ($location){
        $data = [
            'location' => [
                'id' => $location->id,
                'city' => $location->city,
                'street' => $location->street,
                'building' => $location->building,
                'floor' => $location->floor,
                'user' => UserResponse::format($location->user)['user'],
            ]
        ];

        return $data;
    }
}