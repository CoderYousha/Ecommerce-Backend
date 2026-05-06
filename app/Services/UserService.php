<?php

namespace App\Services;

use App\Models\User;
use App\Transformers\Users\UserResponse;
use App\Transformers\Users\UsersResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser($request)
    {
        $path = null;
        if ($request->image) {
            $path = uploadImage($request->image, 'UsersImages');
            $data['image'] = $path;
        }
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp_phone' => $request->whatsapp_phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'full_name' => $request->full_name,
            'status' => $request->status,
            'image' => $path,
        ]);

        return success(UserResponse::format($user), 'User created successfully', 201);
    }

    public function updateUser(User $user, $request)
    {
        if ($request->image) {
            if(File::exists($user->image)){
                File::delete($user->image);
            }
            $path = uploadImage($request->image, 'UsersImages');
            $data['image'] = $path;
        }
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp_phone' => $request->whatsapp_phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'full_name' => $request->full_name,
            'status' => $request->status,
            'image' => $path ?? $user->image,
        ]);

        return success(UserResponse::format($user), 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        if(File::exists($user->image)){
            File::delete($user->image);
        }
        $user->delete();

        return success(null, 'User deleted successfully');
    }

    public function getUsers($perPage, $role, $search)
    {
        // if($role){
            $users = User::where('role', $role)->where(function ($query) use ($search){
                $query->where('full_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })->orderBy('created_at', 'desc')->paginate($perPage ?? 10);
        // }else{
        //     $users = User::paginate($perPage ?? 10);
        // }

        return success(UsersResponse::format($users), 'Users Information');
    }

    public function getUser(User $user)
    {
        return success(UserResponse::format($user), 'User information');
    }
}
