<?php

namespace App\Transformers\Authentications;

class ProfileResponse {
    public static function format ($user) {
        $data = [
            'data' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'whatsapp_phone' => $user->whatsapp_phone,
                'role' => $user->role,
                'image' => $user->image,
            ]
        ];

        return $data;
    }
}