<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('check-auth')->group(function (){
    Route::middleware('employee-auth')->group(function (){
        Route::controller(ProductsController::class)->prefix('products')->group(function (){
            Route::post('/', 'store');
            Route::post('/{product}', 'update');
            Route::delete('/images/{productImage}', 'deleteImage');
            Route::delete('/{product}', 'delete');
        });
    });
});