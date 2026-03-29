<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationsRequests\ForgetPasswordRequest;
use App\Http\Requests\AuthenticationsRequests\LoginRequest;
use App\Http\Requests\AuthenticationsRequests\PasswordRequest;
use App\Http\Requests\AuthenticationsRequests\ProfileRequest;
use App\Http\Requests\AuthenticationsRequests\RegisterRequest;
use App\Http\Requests\AuthenticationsRequests\ResetForgetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    //Login Function
    public function login(LoginRequest $loginRequest)
    {
        return $this->authService->login($loginRequest->email, $loginRequest->password);
    }

    //Register Function
    public function register(RegisterRequest $registerRequest)
    {
        return $this->authService->register($registerRequest);
    }

    //Register Verification Function
    public function registerVerification(Request $request)
    {
        return $this->authService->registerVerify($request->code);
    }

    //Profile Function
    public function profile()
    {
        return $this->authService->profile();
    }

    //Update Profile Function
    public function updateProfile(ProfileRequest $profileRequest)
    {
        return $this->authService->updateProfile($profileRequest->all());
    }

    //Reset Password Function
    public function resetPassword(PasswordRequest $passwordRequest)
    {
        return $this->authService->resetPassword($passwordRequest);
    }

    //Logout Function
    public function logout()
    {
        return $this->authService->logout();
    }

    //Forget Password Function
    public function forgetPassword(ForgetPasswordRequest $forgetPasswordRequest)
    {
        return $this->authService->forgetPassword($forgetPasswordRequest->email);
    }

    //Forget Password Verification Function
    public function forgetPasswordVerification(Request $request)
    {
        return $this->authService->forgetPasswordVerify($request->code);
    }

    //Reset Forget Password Function
    public function resetForgetPasswordVerification(ResetForgetPasswordRequest $resetForgetPasswordRequest)
    {
        return $this->authService->resetForgetPassword($resetForgetPasswordRequest);
    }

    //Store FCM Token Function
    public function storeToken (Request $request){
        return $this->authService->saveToken($request->token);
    }
}
