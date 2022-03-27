<?php

namespace App\Common\Http\Controllers;

use App\Common\Models\User\UserApp;

/**
 * @property UserApp|null $user Пользователь
 */
class AppController extends Controller
{
    public function setConfig(): Controller
    {
        $this->setUser(UserApp::auth())->setAppName();
        return $this;
    }
}
