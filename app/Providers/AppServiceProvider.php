<?php

namespace App\Providers;

use App\Helpers\PaystackHelper;
use App\Models\User;
use App\Observers\UserObserver;
use App\Services\PaystackService;
use App\Services\AuthenticateUser;
use App\Repositories\OTP\OTPInterface;
use Illuminate\Support\Facades\Schema;
use App\Repositories\OTP\SendOTPViaSMS;
use Illuminate\Support\ServiceProvider;
use App\Repositories\OTP\SendOTPViaMail;
use App\Services\AdProductService\AdProductActionService;

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

        $this->app->singleton(PaystackHelper::class, function() {
            return new PaystackHelper(new PaystackService);
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
        User::observe(UserObserver::class);
    }
}
