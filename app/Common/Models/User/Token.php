<?php

namespace App\Common\Models\User;

use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class Token
{
    private string $type;
    private string $model;
    private string $uuid;
    private int $role;
    private int $expired_at;

    public function __construct()
    {

    }

    public function useUser(User $user): Token
    {
        $this->type = 'a';
        $this->model = User::getTypeApp(get_class($user));
        $this->uuid = $user->uuid;
        $this->role = $user->role;
        $this->expired_at = 0;
        return $this;
    }

    public function useJwt(string $token): Token
    {
        return $this;
    }
}
