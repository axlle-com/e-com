<?php

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Http\Controllers\AppController;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class App extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $controller = new AppController($request);
        if (($user = $controller->getUser()) && $token = $user->access_token) {
            if ($token->expired_at > time()) {
                return $next($request);
            }
            return $controller->locked()->error();
        }
        return $controller->error();
    }
}
