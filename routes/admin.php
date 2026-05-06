<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BannersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('check-auth')->group(function () {
    Route::middleware('admin-auth')->group(function () {
        Route::controller(UsersController::class)->prefix('users')->group(function () {
            Route::post('/', 'store');
            Route::post('/{user}', 'update');
            Route::delete('/{user}', 'delete');
            Route::get('/', 'read');
            Route::get('/{user}', 'show');
        });
        Route::controller(CategoriesController::class)->prefix('categories')->group(function () {
            Route::post('/', 'store');
            Route::post('/{category}', 'update');
            Route::delete('/{category}', 'delete');
        });
        Route::controller(BannersController::class)->prefix('banners')->group(function () {
            Route::post('/', 'store');
            Route::post('/{banner}', 'update');
            Route::delete('/{banner}', 'delete');
            Route::delete('/image/{bannerImage}', 'deleteImage');
        });
    });
});
