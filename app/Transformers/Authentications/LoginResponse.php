<?php

namespace App\Transformers\Authentications;

class LoginResponse
{
    public static function format($user, $token)
    {
        $data = [
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'whatsapp_phone' => $user->whatsapp_phone,
                'role' => $user->role,
            ],
            'token' => $token,
        ];

        return $data;
    }
}
