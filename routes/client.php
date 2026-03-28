<?php

use App\Http\Controllers\CartsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\LocationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('check-auth')->group(function () {
    Route::middleware('client-auth')->group(function () {
        Route::controller(FavoritesController::class)->prefix('favorites')->group(function (){
            Route::post('/{product}', 'favorite');
            Route::get('/', 'read');
        });
        Route::controller(CartsController::class)->prefix('carts')->group(function () {
            Route::post('/', 'store');
            Route::post('/{cart}', 'update');
            Route::post('/{cart}/increase', 'increase');
            Route::post('/{cart}/decrease', 'decrease');
            Route::get('/', 'read');
            Route::delete('/{cart}', 'delete');
        });
        Route::controller(LocationsController::class)->prefix('locations')->group(function () {
            Route::post('/', 'store');
            Route::post('/{location}', 'update');
            Route::get('/', 'read');
            Route::get('/{location}', 'show');
            Route::delete('/{location}', 'delete');
        });
    });
});