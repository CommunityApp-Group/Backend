<?php

namespace App\Repositories\Password;

interface PasswordResetInterface {
    public function body();
    public function send();
}