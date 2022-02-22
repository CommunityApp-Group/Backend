<?php

use App\Helpers\PaystackHelper;
use App\Http\Controllers\Api\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Auction\AuctionController;
use App\Http\Controllers\Api\Story\StoryController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Bavix\Wallet\Exceptions\BalanceIsEmpty;
use App\Http\Controllers\Api\AuthController;
use Bavix\Wallet\Exceptions\InsufficientFunds;
use App\Http\Controllers\Api\Wallet\WalletController;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Story\StoryResource;

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

    // Users authentication a
    Route::name('users.')->prefix('users')->group(function () {
        Route::post('create', [AuthController::class, 'createUser'])->name('create');
        Route::post('login', [AuthController::class, 'authenticate'])->name('login');
        Route::get('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh');
        Route::get('current', [AuthController::class, 'authenticatedUser'])->name('current');
        Route::post('verify-account', [AuthController::class, 'verifyAccount'])->name('verify');
        Route::get('resend-code', [AuthController::class, 'resendCode'])->name('resend');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
    });

    Route::name('wallet')->prefix('wallet')->group(function() {
        Route::get('balance', [WalletController::class, 'balance']);
        Route::post('deposit', [WalletController::class, 'deposit']);
    });

    Route::apiResource('story', StoryController::class);
    Route::get('storylist', [StoryController::class, 'storylist'])->name('storylist');
    Route::apiResource('auction', AuctionController::class);
    Route::get('auctionlist', [AuctionController::class, 'auctionlist'])->name('auctionlist');
    Route::apiResource('category', CategoryController::class);
    Route::get('category/find-by-name/{name}', [CategoryController::class, 'findByName']);


    Route::get('list-banks', function(PaystackHelper $paystack) {
        return $paystack->listBanks();
    });


    Route::name('admin.')->prefix('admin')->group(function () {
        Route::patch('auction/update/{auction}', [AdminAuctionController::class, 'update']);
        Route::delete('auction/delete/{auction}', [AdminAuctionController::class, 'destroy']);
    });
    // Route::resource('wallet', WalletController::class);

});
