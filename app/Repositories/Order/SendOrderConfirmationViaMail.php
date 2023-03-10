<?php

namespace App\Repositories\Order;

use App\Notifications\NewOrder;
use App\Repositories\Order\OrderInterface;

class SendOrderConfirmationViaMail implements OrderInterface {

    public function body() {

    }
    public function send() {
        $user = auth('api')->user();
        return $user->notify(new NewOrder);
    }
    public function sendadmin() {
        $admin = auth()->guard('admin')->user()->id;
        return $admin->notify(new NewOrder);
    }

    public function sendToUser($user) {
        return $user->notify(new NewOrder);
    }
    public function sendToAdmin($admin) {
        return $admin->notify(new NewOrder);
    }
}