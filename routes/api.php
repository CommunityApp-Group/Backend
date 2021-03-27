<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Wallet\WalletController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    // Users authentication a
    Route::name('users.')->prefix('users')->group(function () {
        Route::post('create', [AuthController::class, 'createUser'])->name('create');
        Route::post('login', [AuthController::class, 'authenticate'])->name('login');
        Route::get('current', [AuthController::class, 'authenticatedUser'])->name('current');
        // Route::get('{provider}/{user_type}/generate_link', [AuthController::class, 'getAuthLink']);
        // Route::get('callback/{provider}', [AuthController::class, 'handleSocialCallback']);
        Route::post('verify-account', [AuthController::class, 'verifyAccount'])->name('verify');
        Route::get('resend-code', [AuthController::class, 'resendCode'])->name('resend');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
    Route::resource('wallet', WalletController::class);

});