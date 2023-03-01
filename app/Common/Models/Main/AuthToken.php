<?php

namespace App\Common\Models\Main;

use App\Common\Models\User\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use function env;

trait AuthToken
{
    public static int $expired = 0;
    public static int $expiredRefresh = 0;
    public static string $alg = 'HS256';

    public static function tokenStr(bool $refresh = false): string
    {
        return $refresh ? Str::random(200) : Str::random(100);
    }

    public static function jwtToken(User $user, bool $refresh = false): string
    {
        $data = [
            'type' => $refresh ? 'r' : 'a',
            'model' => User::getTypeApp(get_class($user)),
            'id' => $user->id,
            'expired_at' => $refresh ? self::tokenExpiresAt(true) : self::tokenExpiresAt(),
        ];
        return JWT::encode($data, ($refresh ? env('TOKEN_JWT_KEY_WEB_REFRESH') : env('TOKEN_JWT_KEY_WEB')), self::$alg);
    }

    public static function tokenExpiresAt(bool $ref = false): int
    {
        if($ref) {
            self::$expiredRefresh = time() + (60 * 60 * 24 * 30);
            return self::$expiredRefresh;
        }
        self::$expired = time() + (60 * 60 * 24);//
        return self::$expired;
    }

    public static function getJwt(string $token): ?object
    {
        $data = null;
        try {
            $data = JWT::decode($token, env('TOKEN_JWT_KEY_WEB', 'user'), self::$alg);
        } catch(Exception $exception) {
        }
        return $data;
    }
}
