<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Admin;
use App\Helpers\PaystackHelper;
use App\Observers\UserObserver;
use App\Observers\AdminObserver;
use App\Services\PaystackService;
use App\Repositories\OTP\OTPInterface;
use Illuminate\Support\Facades\Schema;
use App\Repositories\OTP\SendOTPViaSMS;
use Illuminate\Support\ServiceProvider;
use App\Repositories\OTP\SendOTPViaMail;
use App\Services\Auth\AuthenticateUser;
use App\Services\Auth\AuthenticateAdmin;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Password\ResetTokenViaMail;
use App\Repositories\Order\SendOrderConfirmationViaMail;
use App\Repositories\Password\PasswordResetInterface;;

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
        $this->app->singleton(PasswordResetInterface::class, function() {
            return new ResetTokenViaMail;
        });
        $this->app->singleton(OrderInterface::class, function() {
            return new SendOrderConfirmationViaMail;
        });

        $this->app->singleton(AuthenticateUser::class, function() {
            return new AuthenticateUser;
        });

        $this->app->singleton(AuthenticateAdmin::class, function() {
            return new AuthenticateAdmin;
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
        Admin::observe(AdminObserver::class);
    }
}
