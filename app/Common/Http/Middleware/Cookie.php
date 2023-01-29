<?php

namespace App\Common\Http\Middleware;

use App\Common\Http\Controllers\WebController;
use Closure;
use Illuminate\Http\Request;

class Cookie
{
    public function handle(Request $request, Closure $next)
    {
        $controller = new WebController($request);
        if($controller->isCookie()) {
            return $next($request);
        }
        abort(404);
    }
}
