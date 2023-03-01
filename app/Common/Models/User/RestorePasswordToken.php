<?php

namespace App\Common\Models\User;

class RestorePasswordToken extends UserToken
{
    public function new(User $user): bool
    {
        if(!$token = static::query()
            ->where('user_id', $user->id)
            ->where('type', self::TYPE_RESTORE_PASSWORD_TOKEN)
            ->first()) {
            $token = new static();
            $token->user_id = $user->id;
            $token->type = self::TYPE_RESTORE_PASSWORD_TOKEN;
        }
        $token->token = self::jwtToken($user);
        $token->expired_at = self::tokenExpiresAt();
        if($token->save()) {
            $user->token = $token;
            return true;
        }
        return false;
    }
}
