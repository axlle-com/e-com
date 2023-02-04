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
        if($user) {
            return redirect('/admin');
        }

        return $this->view('backend.login');
    }

    public function auth(Request $request)
    {
        if($post = $this->validation(UserWeb::rules())) {
            if(($user = UserWeb::validate($post)) && $user->login()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();

                return redirect('/admin');
            }
        }

        return back()->with('error', 'Не правильный логин или пароль');
    }

    public function profile(Request $request)
    {
        $user = UserWeb::auth();

        return $this->view('backend.user.update', [
            'model' => $user,
            'title' => 'Пользователь: ' . $user->first_name,
        ]);
    }
}
