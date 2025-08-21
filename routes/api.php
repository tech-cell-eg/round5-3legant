<?php

use App\Models\User;
use App\Http\Controllers\API\AddressesController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\WishlistController;
use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\Api\EmailVerifyController;
use App\Http\Controllers\ProductController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'sendPasswordResetOTP']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
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


Route::group(['middleware' => ['auth:sanctum']], function () {
    //User Profile
    Route::apiResource('users', UserController::class);
    Route::post('user/addresses', [AddressesController::class, 'store']);
    Route::put('user/addresses/{id}', [AddressesController::class, 'update']);
    Route::delete('user/addresses/{id}', [AddressesController::class, 'destroy']);
    //User wishlist
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{productId}', [WishlistController::class, 'addProduct']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'removeProduct']);
    //User Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::delete('remove-cart-item/{cartItemId}', [CartController::class, 'removeItem']);
    Route::put('update-cart-item/{cartItemId}', [CartController::class, 'updateItem']);
    Route::post('apply-coupon', [CartController::class, 'applyCoupon']);
    Route::post('apply-shipping', [CartController::class, 'applyShipping']);


});



//Home Page
Route::get('/home/categories', [\App\Http\Controllers\Api\HomeController::class, 'categories']);
Route::get('/home/new-arrivals', [\App\Http\Controllers\Api\HomeController::class, 'newArrivals']);
Route::get('/home/more-products', [\App\Http\Controllers\Api\HomeController::class, 'moreProducts']);
Route::get('/home/shop-collections', [\App\Http\Controllers\Api\HomeController::class, 'shopCollections']);
Route::get('/home/best-sellers', [\App\Http\Controllers\Api\HomeController::class, 'bestSellers']);
Route::get('/blog/list', [\App\Http\Controllers\Api\HomeController::class, 'blogList']);
Route::get('/blog/{id}', [\App\Http\Controllers\Api\HomeController::class, 'blogDetails']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('users', UserController::class);
    Route::post('user/addresses', [AddressesController::class, 'store']);
    Route::put('user/addresses/{id}', [AddressesController::class, 'update']);
    Route::delete('user/addresses/{id}', [AddressesController::class, 'destroy']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{productId}', [WishlistController::class, 'addProduct']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'removeProduct']);


    Route::get("/products", [ProductController::class, 'getProductsWithPagination']);
    Route::get("/sorted-products", [ProductController::class, 'sortedProducts']);
    Route::get("/products-without-pagination", [ProductController::class, 'getProductsWithoutPagination']);
    Route::get("/products-search", [ProductController::class, 'productSearch']);
    Route::get("/products/{id}", [ProductController::class, 'productDetails']);
    Route::get("/related-products/{id}", [ProductController::class, 'relatedProducts']);
});


//Home Page
Route::get('/home/categories', [\App\Http\Controllers\Api\HomeController::class, 'categories']);
Route::get('/home/new-arrivals', [\App\Http\Controllers\Api\HomeController::class, 'newArrivals']);
Route::get('/home/more-products', [\App\Http\Controllers\Api\HomeController::class, 'moreProducts']);
Route::get('/home/shop-collections', [\App\Http\Controllers\Api\HomeController::class, 'shopCollections']);
Route::get('/home/best-sellers', [\App\Http\Controllers\Api\HomeController::class, 'bestSellers']);
Route::get('/blog/list', [\App\Http\Controllers\Api\HomeController::class, 'blogList']);
Route::get('/blog/{id}', [\App\Http\Controllers\Api\HomeController::class, 'blogDetails']);
