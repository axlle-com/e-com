<?php

namespace App\Common\Http\Controllers;

use App\Common\Models\User\UserWeb;

/**
 * @property UserWeb|null $user Пользователь
 */
class WebController extends Controller
{
    public function setConfig(): Controller
    {
        $this->setUser(UserWeb::auth())->setAppName('web');
        return $this;
    }
}
