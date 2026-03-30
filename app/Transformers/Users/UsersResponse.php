<?php

namespace App\Transformers\Users;

use App\Transformers\Pagination\PaginationResponse;

class UsersResponse
{
    public static function format($users)
    {
        $data = ['users' => []];

        foreach ($users as $user) {
            $data['users'][] = [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'whatsapp_phone' => $user->whatsapp_phone,
                'role' => $user->role,
                'status' => $user->status,
                'image' => $user->image,
            ];
        }
        $data['pagination'] = PaginationResponse::format($users);

        return $data;
    }
}
