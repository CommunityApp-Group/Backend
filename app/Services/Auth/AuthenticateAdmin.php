<?php


namespace App\Services\Auth;


use App\Helpers\ResourceHelpers;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class AuthenticateAdmin
{

    public $errorMessage = [];
    public $admin;

    public function authenticate()
    {
        try {
            JWTAuth::parseToken()->authenticate();
            if (! $admin = auth()->guard('admin')->user()) {
                $this->errorMessage = ['title' => 'Admin not found', 'message' => [], 'status' => 404];
                return false;
            }
        } catch (TokenExpiredException $e) {
            $this->errorMessage = ['title' => 'Token Expired', 'message' => ["token" => $e->getMessage()]];
            return false;
        } catch (TokenInvalidException $e) {
            $this->errorMessage = ['title' => 'Token Invalid', 'message' => ["token" => $e->getMessage()]];
            return false;
        } catch (JWTException $e) {
            $this->errorMessage = ['title' => 'Token Absent', 'message' => ["token" => $e->getMessage()]];
            return false;
        }
        $this->admin = $admin;
        return true;
    }

    public function authFailed()
    {
        $error = $this->errorMessage;
        return response()->errorResponse($error['title'], $error['message'], isset($error['status']) ? $error['status'] : 401);
    }

    public function authSuccessful()
    {
        return ResourceHelpers::returnAdminData($this->admin);
    }

}