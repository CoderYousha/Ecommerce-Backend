<?php

namespace App\Services;

use App\Mail\VerificationMessage;
use App\Models\User;
use App\Models\Verification;
use App\Transformers\Authentications\LoginResponse;
use App\Transformers\Authentications\ProfileResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken('user')->plainTextToken;
            return success(LoginResponse::format($user, $token), 'Login successfully');
        }

        return error('some thing went wrong', 'Incorrect email or password', 400);
    }

    public function register($request)
    {
        $verification = Verification::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp_phone' => $request->whatsapp_phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'code' => rand(111111, 999999),
            'expiry_date' => Carbon::now()->addMinutes(15),
        ]);

        // try {
        //     Mail::to($verification->email)->send(new VerificationMessage($verification->code));
        // } catch (Exception $e) {
        //     $verification->delete();
        //     return error('some thing went wrong', 'Cannot send verification code, try arain later....', 422);
        // }

        $token = $verification->createToken('verification')->plainTextToken;

        return success($token, 'We sent verification code to your email', 201);
    }

    public function registerVerify($code)
    {
        $verification = Auth::guard('verification')->user();

        if ($verification && $code == $verification->code && Carbon::now() < $verification->expiry_date) {
            $user = User::create([
                'full_name' => $verification->full_name,
                'email' => $verification->email,
                'phone' => $verification->phone,
                'whatsapp_phone' => $verification->whatsapp_phone,
                'password' => $verification->password,
                'role' => $verification->role,
            ]);
            $token = $user->createToken('user')->plainTextToken;
            $verification->delete();

            return success(LoginResponse::format($user, $token), 'Registering completed succcessfully', 201);
        }

        return error('something went wrong', 'Incorrect verification code');
    }

    public function profile()
    {
        $profile = Auth::guard('user')->user();

        return success(ProfileResponse::format($profile), 'Profile information');
    }

    public function updateProfile($data)
    {
        $profile = Auth::guard('user')->user();

        $profile->update($data);

        return success(ProfileResponse::format($profile), 'Profile updated successfully');
    }

    public function resetPassword($request)
    {
        $user = Auth::guard('user')->user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return success(null, 'Your password updated successfully');
        }

        return error('some thing went wrong', 'Incorrect password');
    }

    public function logout()
    {
        Auth::guard('user')->user()->tokens()->delete();

        return success(null, 'Logout successfully');
    }

    public function forgetPassword($email)
    {
        $verification = Verification::create([
            'email' => $email,
            'code' => rand(111111, 999999),
            'expiry_date' => Carbon::now()->addMinutes(15),
        ]);

        // try {
        //     Mail::to($verification->email)->send(new VerificationMessage($verification->code));
        // } catch (Exception $e) {
        //     $verification->delete();
        //     return error('some thing went wrong', 'Cannot send verification code, try arain later....', 422);
        // }

        $token = $verification->createToken('verification')->plainTextToken;

        return success($token, 'We ssent verification code to your email', 201);
    }

    public function forgetPasswordVerify($code)
    {
        $verification = Auth::guard('verification')->user();

        if ($verification && $code == $verification->code && Carbon::now() < $verification->expiry_date) {
            $user = User::where('email',$verification->email)->first();
            $token = $user->createToken('reset-password')->plainTextToken;
            $verification->delete();

            return success($token, 'Checked successfully');
        }

        return error('something went wrong', 'Incorrect verification code');
    }

    public function resetForgetPassword($request){
        $user = Auth::guard('reset-password')->user();

        if($user){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            $user->tokens()->delete();

            return success(null, 'Your password updated successfully');
        }
        return error('some thing went wrong', 'Forbidden', 403);
    }
}
