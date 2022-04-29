<?php

namespace App\Common\Models\User;

class VerificationToken extends UserToken
{
    public function create(User $user): bool
    {
        $token = $user->token;
        if (!$token) {
            $token->type = self::TYPE_VERIFICATION_TOKEN;
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
