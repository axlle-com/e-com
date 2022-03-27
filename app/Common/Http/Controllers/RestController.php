<?php

namespace App\Common\Http\Controllers;

use App\Common\Models\User\UserRest;

/**
 * @property UserRest|null $user Пользователь
 */
class RestController extends Controller
{
    public function setConfig(): Controller
    {
        $this->setUser(UserRest::auth())->setAppName('rest');
        return $this;
    }
}
