<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::group(['middleware' => ['role:admin|Sadmin']], function () {
    Route::get("/admin/dashboard", [UserController::class, "adminDashboard"])->name('adminDashboard');
    Route::get("/admin/dashboard/orders", [OrderController::class, "orders"])->name("orders");
    Route::post('/admin/dashboard/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::group(['middleware' => ['role:Sadmin']], function () {
    Route::get("/admin/dashboard/users", [UserController::class, "userManagmentView"])->name("users");
    Route::get("/admin/dashboard/users/create", [UserController::class, "createUserView"])->name("users.createUserView");
    Route::post("/admin/dashboard/users/create", [UserController::class, "createUser"])->name("users.createUser");
    Route::get("/admin/dashboard/users/edit/{id}", [UserController::class, "userEdit"])->name("users.edit");
    Route::put("/admin/dashboard/users/update/{id}", [UserController::class, "userUpdate"])->name("users.update");
    Route::delete("/admin/dashboard/users/delete/{id}", [UserController::class, "userDelete"])->name("users.delete");
    Route::get("/admin/dashboard/users/{id}", [UserController::class, "userView"])->name("users.view");
});

