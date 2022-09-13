<?php

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class JWT extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $controller = new Controller($request);
        if ($controller->setUserJwt()->getToken()) {
            if ($auth = $controller->getUserJwt()) {
                if ($auth->expired_at > time()) {
                    return $next($request);
                }
                return $controller->locked()->error();
            }
            return $controller->error();
        }
        return $controller->error();
    }
}
