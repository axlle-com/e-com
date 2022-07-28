<?php

namespace App\Common\Models\User;

class UserApp extends User
{
    public function authFields(): array
    {
        return array_merge($this->fields(), [
            'access_token' => $this->access_token->token,
            'refresh_token' => $this->refresh_access_token->token,
        ]);
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
