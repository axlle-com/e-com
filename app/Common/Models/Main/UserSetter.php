<?php

namespace App\Common\Models\Main;

use App\Common\Models\User\User;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;

/**
 * @property User|null $userSetter
 */
trait UserSetter
{
    public ?User $userSetter;

    public function setUser(?User $user = null): static
    {
        if ($user) {
            $this->userSetter = $user;
        } else if (($userAuth = UserWeb::auth()) || ($userAuth = UserRest::auth()) || ($userAuth = UserApp::auth())) {
            $this->userSetter = $userAuth;
        } else {
            $this->userSetter = null;
        }
        return $this;
    }
}
