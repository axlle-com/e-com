<?php

namespace App\Common\Models\User;

class UserApp extends User
{
    public function authFields(): array
    {
        return array_merge($this->getFields(), [
            'access_token' => $this->app_access_token->token,
            'refresh_token' => $this->app_refresh_access_token->token,
        ]);
    }

    public function login(): bool
    {
        return UserToken::createAppToken($this) && UserToken::createAppRefreshToken($this);
    }

    public function logout(): bool
    {
        $this->app_access_token->token = null;
        $this->app_access_token->expired_at = null;
        $this->app_refresh_access_token->token = null;
        $this->app_refresh_access_token->expired_at = null;
        return $this->app_access_token->save() && $this->app_refresh_access_token->save();
    }
}
