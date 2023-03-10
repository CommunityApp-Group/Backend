<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next, $auth="admin")
    {

        $admin = auth()->guard('admin')->user();

        if($auth == 'super_admin') {
            if(!$admin->can('super_admin')) {
                return response()->errorResponse('Access Denied',  ["Authority" => "You are not allowed to access this resource"], 403);
            }
        }

        return $next($request);
    }
}
