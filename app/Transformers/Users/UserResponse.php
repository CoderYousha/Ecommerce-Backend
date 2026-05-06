<?php

namespace App\Transformers\Users;

class UserResponse
{
    public static function format($user)
    {
        $data = [
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'whatsapp_phone' => $user->whatsapp_phone,
                'role' => $user->role,
                'status' => $user->status,
                'image' => $user->image,
            ]
        ];

        return $data;
    }
}
