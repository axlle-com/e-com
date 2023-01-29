<?php

namespace App\Common\Http\Middleware;

use App\Common\Models\User\UserWeb;
use Closure;
use Illuminate\Http\Request;

class Register
{
    public function handle(Request $request, Closure $next)
    {
        if(UserWeb::auth()) {
            return $next($request);
        }
        abort(404);
    }
}
