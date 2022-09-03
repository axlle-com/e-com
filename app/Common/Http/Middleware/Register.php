<?php

namespace App\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Common\Models\User\UserWeb;

class Register
{
    public function handle(Request $request, Closure $next)
    {
        if (UserWeb::auth()) {
            return $next($request);
        }
        abort(404);
    }
}
