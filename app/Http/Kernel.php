<?php

namespace App\Http;

use App\Common\Http\Middleware\Api;
use App\Common\Http\Middleware\App;
use App\Common\Http\Middleware\JWT;
use App\Http\Middleware\TrimStrings;
use App\Common\Http\Middleware\Admin;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\Authenticate;
use App\Common\Http\Middleware\Cookie;
use App\Http\Middleware\EncryptCookies;
use App\Common\Http\Middleware\Register;
use App\Http\Middleware\VerifyCsrfToken;
use App\Common\Http\Middleware\ExistRate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [// \App\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [// \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var $routeMiddleware array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'api' => Api::class,
        'jwt' => JWT::class,
        'admin' => Admin::class,
        'app' => App::class,
        'rate' => ExistRate::class, # заглушка
        'register' => Register::class, # заглушка
        'cookie' => Cookie::class, # проверка кук
    ];
}
