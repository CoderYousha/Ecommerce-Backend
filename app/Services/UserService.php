<?php

namespace App\Services;

use App\Models\User;
use App\Transformers\Users\UserResponse;
use App\Transformers\Users\UsersResponse;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser($request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp_phone' => $request->whatsapp_phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'full_name' => $request->full_name,
            'status' => $request->status,
        ]);

        return success(UserResponse::format($user), 'User created successfully', 201);
    }

    public function updateUser(User $user, $request)
    {
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp_phone' => $request->whatsapp_phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'full_name' => $request->full_name,
            'status' => $request->status,
        ]);

        return success(UserResponse::format($user), 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return success(null, 'User deleted successfully');
    }

    public function getUsers($perPage)
    {
        $users = User::paginate($perPage ?? 10);

        return success(UsersResponse::format($users), 'Users Information');
    }

    public function getUser(User $user) {
        return success(UserResponse::format($user), 'User information');
    }
}
