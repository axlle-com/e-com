<?php

namespace App\Common\Http\Middleware;

use App\Common\Models\User\UserWeb;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        $array = explode('/', URL::current());
        $user = UserWeb::auth();
        $isEmployee = $user && in_array('employee', $user->getSessionRoles(), true);
        $isLogin = ! empty($array[4]) && $array[4] === 'login';
        if ($isEmployee || $isLogin) {
            return $next($request);
        }
        abort(404);
    }
}
