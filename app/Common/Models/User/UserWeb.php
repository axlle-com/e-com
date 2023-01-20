<?php

namespace App\Common\Models\User;

use Illuminate\Database\Eloquent\Relations\HasOne;

class UserWeb extends User
{
    public function tokenResetPassword(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id', 'id')->where('type', UserToken::TYPE_RESTORE_PASSWORD_TOKEN);
    }
}
