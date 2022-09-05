<?php

namespace App\Common\Models\User;

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
