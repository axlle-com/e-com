<?php

namespace App\Providers;

use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('app-token', static function ($request) {
            if ($request->bearerToken()) {
                return UserApp::query()->whereHas('token', static function (Builder $query) use ($request) {
                    $query->where('token', $request->bearerToken());
                })->first();
            }
            return null;
        });

        Auth::viaRequest('rest-token', static function ($request) {
            if ($request->bearerToken()) {
                return UserRest::query()->whereHas('token', static function (Builder $query) use ($request) {
                    $query->where('token', $request->bearerToken());
                })->first();
            }
            return null;
        });
    }
}
