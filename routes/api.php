<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Api\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Auction\AuctionController;
use App\Http\Controllers\Api\Product\ProductreviewController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Post\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    // Users authentication
    Route::name('users.')->prefix('users')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'authenticate'])->name('login');
        Route::get('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh');
        Route::get('current', [AuthController::class, 'authenticatedUser'])->name('current');
        Route::post('verify-account', [AuthController::class, 'verifyAccount'])->name('verify');
        Route::get('resend-code', [AuthController::class, 'resendCode'])->name('resend');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::patch('profile/{profile}', [ProfileController::class, 'update'])->name('update.profile');
            });


    Route::apiResource('category', CategoryController::class);
    Route::get('category/find-by-name/{name}', [CategoryController::class, 'findByName']);

    // User CRUD operations
    Route::apiResource('auction', AuctionController::class);
    Route::get('myauction', [AuctionController::class, 'myauction'])->name('myauction');
    Route::apiResource('post', PostController::class);
    Route::get('mypost', [PostController::class, 'mypost'])->name('mypost');
    Route::get('popularpost', [PostController::class, 'popularpost'])->name('popularpost');
    Route::apiResource('product', ProductController::class);
    Route::get('myproduct', [ProductController::class, 'myproduct'])->name('myproduct');
    Route::get('popularproduct', [ProductController::class, 'popularproduct'])->name('popularproduct');
    Route::group(['prefix'=>'products'],function(){
        Route::apiResource('/{product}/reviews',ProductReviewController::class);
    });


    // Admin Op
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::patch('auction/update/{auction}', [AdminAuctionController::class, 'update']);
        Route::delete('auction/delete/{auction}', [AdminAuctionController::class, 'destroy']);
        Route::delete('post/delete/{post}', [AdminPostController::class, 'destroy']);
        Route::delete('product/delete/{product}', [AdminProductController::class, 'destroy']);
    });


});
