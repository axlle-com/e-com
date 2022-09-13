<?php

namespace App\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Common\Models\User\UserWeb;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (($user = UserWeb::auth()) && in_array('employee', $user->getSessionRoles(), true)) {
            return $next($request);
        }
        abort(404);
    }
}
