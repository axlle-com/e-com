<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\Request;

class UserController extends BackendController
{
    public function login(Request $request)
    {
        $user = UserWeb::auth();

        return $this->view('backend.user.update', ['model' => $user, 'title' => 'Пользователь: '.$user->first_name,]);
    }

    public function profile(Request $request)
    {
        $user = UserWeb::auth();

        return $this->view('backend.user.update', ['model' => $user, 'title' => 'Пользователь: '.$user->first_name,]);
    }
}
