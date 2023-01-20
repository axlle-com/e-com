<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\AuthToken;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $token
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int|null $expired_at
 *
 * @property User $user
 */
class UserToken extends BaseModel
{
    use AuthToken;

    public const TYPE_REST_ACCESS = 'rest-access';
    public const TYPE_REST_REFRESH = 'rest-refresh';
    public const TYPE_APP_ACCESS = 'app-access';
    public const TYPE_APP_REFRESH = 'app-refresh';
    public const TYPE_VERIFICATION_TOKEN = 'verification-token';
    public const TYPE_RESTORE_PASSWORD_TOKEN = 'restore-password-token';
    protected $table = 'ax_user_token';

    public function new(User $user): bool
    {
        $token = $user->token;
        if (!$token) {
            $token = new static();
            $token->user_id = $user->id;
            if ($this instanceof AppToken) {
                $token->type = self::TYPE_APP_ACCESS;
            }
            if ($this instanceof RestToken) {
                $token->type = self::TYPE_REST_ACCESS;
            }
        }
        $token->token = empty($token->token) ? self::jwtToken($user) : $token->token;
        $token->expired_at = self::tokenExpiresAt();
        if ($token->save()) {
            $user->token = $token;
            return true;
        }
        return false;
    }

    public function createRefresh(User $user): bool
    {
        $token = $user->tokenRefresh;
        if (!$token) {
            $token = new static();
            $token->user_id = $user->id;
            if ($this instanceof AppToken) {
                $token->type = self::TYPE_APP_REFRESH;
            }
            if ($this instanceof RestToken) {
                $token->type = self::TYPE_REST_REFRESH;
            }
        }
        $token->token = self::jwtToken($user, true);
        $token->expired_at = self::tokenExpiresAt(true);
        if (!$token->safe()->getErrors()) {
            $user->tokenRefresh = $token;
            return true;
        }
        return false;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
