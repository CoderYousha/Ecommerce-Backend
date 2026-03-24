<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/register-verify', 'registerVerification');
    Route::post('/forget-password', 'forgetPassword');
    Route::post('/forget-password-verify', 'forgetPasswordVerification');
    Route::post('/reset-forget-password', 'resetForgetPasswordVerification');
    Route::middleware('check-auth')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', 'profile');
            Route::post('/', 'updateProfile');
        });
        Route::post('/reset-password', 'resetPassword');
        Route::post('/logout', 'logout');
    });
});

Route::middleware('check-auth')->group(function () {
    Route::controller(CategoriesController::class)->prefix('categories')->group(function (){
        Route::get('/', 'read');
        Route::get('/{category}', 'show');
    });
});