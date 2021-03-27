<?php

namespace App\Providers;

use App\Repositories\OTP\OTPInterface;
use Illuminate\Support\Facades\Schema;
use App\Repositories\OTP\SendOTPViaSMS;
use Illuminate\Support\ServiceProvider;
use App\Repositories\OTP\SendOTPViaMail;
use App\Services\AdProductService\AdProductActionService;
use App\Services\AuthenticateUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OTPInterface::class, function() {
            return new SendOTPViaMail;
            // return new SendOTPViaSMS;
        });

        $this->app->singleton(AuthenticateUser::class, function() {
            return new AuthenticateUser;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
