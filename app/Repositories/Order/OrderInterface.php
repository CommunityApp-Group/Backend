<?php

namespace App\Repositories\Order;

interface OrderInterface {
    public function body();
    public function send();
    public function sendadmin();
}