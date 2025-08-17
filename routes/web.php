<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VaritaionsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'role:admin|Sadmin'])->prefix('admin')->group(function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::delete('/product/variation/{id}', [VaritaionsController::class, 'deleteVariation']);
    Route::delete('/product/variation/images/{id}', [VaritaionsController::class, 'deleteVariationImage'])->name('variation-images.destroy');
    Route::get("/dashboard/orders", [OrderController::class, "orders"])->name("orders");
    Route::post('/dashboard/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});


Route::middleware(['auth', 'role:Sadmin'])->prefix('admin')->group(function () {
    Route::get("/dashboard/users", [UserController::class, "userManagmentView"])->name("users");
    Route::get("/dashboard/users/create", [UserController::class, "createUserView"])->name("users.createUserView");
    Route::post("/dashboard/users/create", [UserController::class, "createUser"])->name("users.createUser");
    Route::get("/dashboard/users/edit/{id}", [UserController::class, "userEdit"])->name("users.edit");
    Route::put("/dashboard/users/update/{id}", [UserController::class, "userUpdate"])->name("users.update");
    Route::delete("/dashboard/users/delete/{id}", [UserController::class, "userDelete"])->name("users.delete");
    Route::get("/dashboard/users/{id}", [UserController::class, "userView"])->name("users.view");
});
