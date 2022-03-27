<?php

namespace App\Common\Models\User;

class UserRest extends User
{
    public function authFields(): array
    {
        return array_merge($this->getFields(), [
            'access_token' => $this->access_token->token,
            'access_token_expires_at' => $this->access_token->expired_at,
            'refresh_token' => $this->refresh_access_token->token,
        ]);
    }

    public function login(): bool
    {
        return UserToken::createRestToken($this) && UserToken::createRestRefreshToken($this);
    }

    public function logout(): bool
    {
        $this->access_token->token = null;
        $this->access_token->expired_at = null;
        $this->refresh_access_token->token = null;
        $this->refresh_access_token->expired_at = null;
        return $this->access_token->save() && $this->refresh_access_token->save();
    }
}
