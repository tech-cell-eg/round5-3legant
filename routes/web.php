<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'role:admin|Sadmin'])->prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.home');
    })->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
});
