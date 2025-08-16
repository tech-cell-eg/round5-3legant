<?php

use App\Http\Controllers\API\AddressesController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\WishlistController;
use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\ProductController;
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
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');





Route::get("/products",[ProductController::class,'getProductsWithPagination']);
Route::get("/sorted-products",[ProductController::class,'sortedProducts']);
Route::get("/products-without-pagination",[ProductController::class,'getProductsWithoutPagination']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::apiResource('users', UserController::class);
    Route::post('user/addresses',[AddressesController::class,'store']);
    Route::put('user/addresses/{id}',[AddressesController::class,'update']);
    Route::delete('user/addresses/{id}',[AddressesController::class,'destroy']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{productId}', [WishlistController::class, 'addProduct']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'removeProduct']);
});
  
 
//Home Page
  Route::get('/home/categories', [\App\Http\Controllers\Api\HomeController::class, 'categories']);
  Route::get('/home/new-arrivals', [\App\Http\Controllers\Api\HomeController::class, 'newArrivals']);
  Route::get('/home/more-products', [\App\Http\Controllers\Api\HomeController::class, 'moreProducts']);
  Route::get('/home/shop-collections', [\App\Http\Controllers\Api\HomeController::class, 'shopCollections']);
  Route::get('/home/best-sellers', [\App\Http\Controllers\Api\HomeController::class, 'bestSellers']);
  Route::get('/blog/list', [\App\Http\Controllers\Api\HomeController::class, 'blogList']);
  Route::get('/blog/{id}', [\App\Http\Controllers\Api\HomeController::class, 'blogDetails']);
  





