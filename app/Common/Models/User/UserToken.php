<?php

namespace App\Common\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
class UserToken extends Model
{
    use SoftDeletes, AuthToken;

    public const TYPE_REST_ACCESS = 'rest-access';
    public const TYPE_REST_REFRESH = 'rest-refresh';
    public const TYPE_APP_ACCESS = 'app-access';
    public const TYPE_APP_REFRESH = 'app-refresh';
    protected $table = 'ax_user_token';
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function createRestToken(User $user): bool
    {
        $token = $user->access_token;
        if (!$token) {
            $token = new self();
            $token->user_id = $user->id;
            $token->type = static::TYPE_REST_ACCESS;
        }
        $token->token = empty($token->token) ? self::jwtToken($user) : $token->token;
        $token->expired_at = self::tokenExpiresAt();
        if ($token->save()) {
            $user->_access_token = $token;
            return true;
        }
        return false;
    }

    public static function createRestRefreshToken(User $user): bool
    {
        $token = $user->refresh_access_token;
        if (!$token) {
            $token = new self();
            $token->user_id = $user->id;
            $token->type = static::TYPE_REST_REFRESH;
        }
        $token->token = self::jwtToken($user, true);
        if ($token->save()) {
            $user->_refresh_access_token = $token;
            return true;
        }
        return false;
    }

    public static function createAppToken(User $user): bool
    {
        $token = $user->app_access_token;
        if (!$token) {
            $token = new self();
            $token->user_id = $user->id;
            $token->type = static::TYPE_APP_ACCESS;
        }
        $token->token = self::jwtToken($user);
        $token->expired_at = self::$expired;
        if ($token->save()) {
            $user->_app_access_token = $token;
            return true;
        }
        return false;
    }

    public static function createAppRefreshToken(User $user): bool
    {
        $token = $user->app_refresh_access_token;
        if (!$token) {
            $token = new self();
            $token->user_id = $user->id;
            $token->type = static::TYPE_APP_REFRESH;
        }
        $token->token = self::jwtToken($user, true);
        $token->expired_at = self::$expiredRefresh;
        if ($token->save()) {
            $user->_app_refresh_access_token = $token;
            return true;
        }
        return false;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', $this->getKeyName());
    }

}
