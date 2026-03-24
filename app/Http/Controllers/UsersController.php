<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequests\CreateUserRequest;
use App\Http\Requests\UsersRequests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //Create User Function
    public function store(CreateUserRequest $createUserRequest)
    {
        return $this->userService->createUser($createUserRequest);
    }

    //Update User Function
    public function update(User $user, UpdateUserRequest $updateUserRequest)
    {
        return $this->userService->updateUser($user, $updateUserRequest);
    }

    //Delete User Function
    public function delete (User $user) {
        return $this->userService->deleteUser($user);
    }

    //Get Users Function
    public function read (Request $request) {
        return $this->userService->getUsers($request->per_page);
    }

    //Get User Information Function
    public function show (User $user) {
        return $this->userService->getUser($user);
    }
}
