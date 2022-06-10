<?php

namespace App\Common\Models\Main;

use App\Common\Models\Ips;
use App\Common\Models\User\User;
use Illuminate\Support\Facades\DB;

/**
 * @property User|null $userSetter
 */
trait UserSetter
{
    public ?User $userSetter;

    public function setUser(?User $user): static
    {
        $this->userSetter = $user;
        return $this;
    }
}
