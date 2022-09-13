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

    public function useJwt(string $token): Token
    {
        return $this;
    }
}
