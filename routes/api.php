<?php

use App\Http\Controllers\Api\Accommodation\AccommodationController;
use App\Http\Controllers\Api\Accommodation\AccommodationOrderController;
use App\Http\Controllers\Api\Accommodation\AccommodationReviewController;
use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Api\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\Auction\BidController;
use App\Http\Controllers\Api\Product\Order\CartController;
use App\Http\Controllers\Api\Product\Order\Ordercontroller;
use App\Http\Controllers\Api\Post\PostCommentController;
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
        Route::post('admin', [AuthController::class, 'login'])->name('alogin');
        Route::get('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh');
        Route::get('current', [AuthController::class, 'authenticatedUser'])->name('current');
        Route::post('verify-account', [AuthController::class, 'verifyAccount'])->name('verify');
        Route::get('resend-code', [AuthController::class, 'resendCode'])->name('resend');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::apiResource('profile', ProfileController::class);
            });


    Route::apiResource('category', CategoryController::class);
    Route::get('category/find-by-name/{name}', [CategoryController::class, 'findByName']);

    // User CRUD operations
    Route::apiResource('accommodations', AccommodationController::class);
    Route::get('accommodations/search/{title}', [AccommodationController::class, 'search'])->name('accommodationsearch');
    Route::get('accommodations/my', [AccommodationController::class, 'myaccommodation'])->name('myaccommodation');
    Route::get('accommodations/popular', [AccommodationController::class, 'popularaccommodation'])->name('popularaccommodation');
    Route::group(['prefix'=>'accommodations'],function(){
        Route::apiResource('/{accommodation}/reviews',AccommodationReviewController::class);
        Route::apiResource('/order',AccommodationOrderController::class);
    });

    //Auction management and order
    Route::apiResource('auctions', AuctionController::class);
    Route::group(['prefix'=>'auction'],function(){
        Route::get('myauctions', [AuctionController::class, 'myauction'])->name('myauction');
        Route::get('search/{auction_name}', [AuctionController::class, 'search'])->name('auctionsearch');
        Route::apiResource('bid', BidController::class);
        Route::patch('updatestatus/{bid}', [BidController::class, 'updatestatus'])->name('updatestatus');
    });

    //Post management and comment
    Route::apiResource('posts', PostController::class);
    Route::apiResource('postwithcomment', PostCommentController::class);
    Route::group(['prefix'=>'post'],function(){
        Route::get('myposts', [PostController::class, 'mypost'])->name('myposts');
        Route::get('popularposts', [PostController::class, 'popularpost'])->name('popularpost');
        Route::get('search/{post}', [PostController::class, 'search'])->name('postsearch');
        Route::apiResource('/{post}/comment',PostCommentController::class);
    });

    //Product management and order
    Route::apiResource('products', ProductController::class);
    Route::group(['prefix'=>'product'],function(){
    Route::get('search/{product_name}', [ProductController::class, 'search'])->name('productsearch');
    Route::get('myproduct', [ProductController::class, 'myproduct'])->name('myproduct');
    Route::get('popular', [ProductController::class, 'popularproduct'])->name('popularproduct');
    Route::apiResource('/{product}/productreviews',ProductReviewController::class);
    Route::apiResource('carts', CartController::class);
    Route::apiResource('orders', OrderController::class);

    });


    // Admin authentication
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::post('login', [AdminAuthController::class, 'login'])->name('adminlogin');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('adminlogout');
        Route::post('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [AdminAuthController::class, 'resetPassword']);
        Route::post('refresh', [AdminAuthController::class, 'refresh'])->name('adminrefresh');
        Route::post('me', [AdminAuthController::class, 'me'])->name('adminme');
        Route::get('user', [AdminAuthController::class, 'user'])->name('user');
        Route::apiResource('admin', AdminAuthController::class);
    });
    // Admin Op
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::patch('auction/update/{auction}', [AdminAuctionController::class, 'update']);
        Route::delete('auction/delete/{auction}', [AdminAuctionController::class, 'destroy']);
        Route::delete('post/delete/{post}', [AdminPostController::class, 'destroy']);
        Route::delete('product/delete/{product}', [AdminProductController::class, 'destroy']);
    });


});
