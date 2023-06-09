<?php
namespace App\Repositories\Password;

use App\Notifications\ResetPasswordNotification;

class ResetTokenViaMail implements PasswordResetInterface
{
    public function body() {

    }
    public function send() {
        $user = auth('api')->user();
        return $user->notify(new ResetPasswordNotification);
    }

    public function sendToUser($user) {
        return $user->notify(new ResetPasswordNotification);
    }
}