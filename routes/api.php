<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/sign-up', [AuthController::class, 'SignUp']);
        Route::post('/sign-in', [AuthController::class, 'SignIn']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'Logout']);
        });
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'GetProducts']);

        Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
            Route::get('/my', [ProductController::class, 'GetMyProducts']);
            Route::post('/', [ProductController::class, 'CreateProduct']);
            Route::put('/{product_id}', [ProductController::class, 'UpdateProductById']);
            Route::delete('/{product_id}', [ProductController::class, 'DeleteProductById']);
        });
    });

    Route::prefix('orders')->group(function() {
        Route::middleware(['auth:sanctum', 'is_customer'])->group(function() {
            Route::get('/my', [OrderController::class, 'GetMyOrders']);
            Route::post('/', [OrderController::class, 'CreateOrder']);
        });

        Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
        });
        Route::get('/products/{product_id}', [OrderController::class, 'ShowOrdersOfMyProduct']);
    });
});
