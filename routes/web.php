<?php

use App\Http\Controllers\AdminContorller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([], function () {
  Route::get('/', [AuthController::class, 'ShowLogin'])->name('auth.show.login');
  Route::get('/regisration', [AuthController::class, 'ShowRegistration'])->name('auth.show.registration');

  Route::middleware(['auth', 'is_customer'])->prefix('customer')->group(function() {
    Route::get('/products', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/order/{order_id}', [CustomerController::class, 'getOrderPage'])->name('customer.order');
    Route::get('/logout', [AuthController::class, 'Logout'])->name('customer.logout'); 
  });
});

Route::prefix('/admin')->group(function() {
  Route::get('/login', [AuthController::class, 'ShowAdminLogin'])->name('admin.show.login');
  Route::get('/regisration', [AuthController::class, 'ShowAdminRegistration'])->name('admin.show.registration');

  Route::middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/', [AdminContorller::class, 'index'])->name('admin.index');
    Route::get('/logout', [AuthController::class, 'Logout'])->name('admin.logout'); 
    Route::get('/create-product', [AuthController::class, 'ShowCreateProduct'])->name('admin.create.product');
    Route::get('/update-product/{product_id}', [AuthController::class, 'ShowUpdateProduct'])->name('admin.update.product');
  });
});

Route::prefix('auth')->group(function () {
  Route::post('/sign-up', [AuthController::class, 'SignUp'])->name('auth.signup');
  Route::post('/sign-in', [AuthController::class, 'SignIn'])->name('auth.signin');

  Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout'])->name('auth.logout');
  });
});

Route::prefix('products')->group(function () {
  Route::get('/', [ProductController::class, 'GetProducts'])->name('products.get');

  Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/my', [ProductController::class, 'GetMyProducts'])->name('products.get.my');
    Route::post('/', [ProductController::class, 'CreateProduct'])->name('products.create');
    Route::put('/update/{product_id}', [ProductController::class, 'UpdateProductById'])->name('products.update');
    Route::get('/{product_id}', [ProductController::class, 'DeleteProductById'])->name('products.delete');
  });
});

Route::prefix('orders')->group(function () {
  Route::middleware(['auth', 'is_customer'])->group(function () {
    Route::get('/my', [OrderController::class, 'GetMyOrders'])->name('orders.my');
    Route::post('/', [OrderController::class, 'CreateOrder'])->name('orders.create');
  });

  Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::put('/change-order-status/{order_id}', [OrderController::class, 'ChangeOrderStatus']);
  });

  Route::get('/products/{product_id}', [OrderController::class, 'ShowOrdersOfMyProduct'])->name('show.orders.of.my.product');
});
