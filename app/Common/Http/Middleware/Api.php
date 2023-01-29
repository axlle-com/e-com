<?php

namespace App\Common\Http\Middleware;

use App\Common\Http\Controllers\Controller;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Api extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (in_array('rest', $guards, true) && Auth::guard('rest')->guest()) {
            return Controller::errorStatic();
        }
        if (in_array('app', $guards, true) && Auth::guard('app')->guest()) {
            return Controller::errorStatic(app: Controller::APP_APP);
        }

        return $next($request);
    }
}
