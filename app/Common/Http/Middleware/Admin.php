<?php

namespace App\Common\Http\Middleware;

use App\Common\Models\User\UserWeb;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (($user = UserWeb::auth()) && $user->hasPermissionTo(config('app.permission_entrance_allowed'))) {
            return $next($request);
        }
        abort(404);
    }
}
