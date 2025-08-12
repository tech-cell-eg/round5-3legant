<?php

use App\Models\User;
use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Api\EmailVerifyController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'sendPasswordResetMessage']);
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 400);
    }
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!'], 201);
})->middleware(['throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
