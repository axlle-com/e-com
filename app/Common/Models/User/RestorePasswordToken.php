<?php

namespace App\Common\Models\User;

class RestorePasswordToken extends UserToken
{
    public function create(User $user): bool
    {
        $token = $user->token;
        if (!$token) {
            $token = new static();
            $token->user_id = $user->id;
            $token->type = self::TYPE_RESTORE_PASSWORD_TOKEN;
        }
        $token->token = self::jwtToken($user);
        $token->expired_at = self::tokenExpiresAt();
        if ($token->save()) {
            $user->token = $token;
            return true;
        }
        return false;
    }
}