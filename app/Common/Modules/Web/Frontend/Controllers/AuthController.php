<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthController extends WebController
{
    public function login()
    {
        if ($post = $this->validation(UserWeb::rules())) {
            if (($user = UserWeb::validate($post)) && $user->login()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        return view('backend.login', ['post' => $post]);
    }

    public function logout()
    {
        Auth::logout();
        session(['_user' => []]);
        return redirect(RouteServiceProvider::HOME);
    }
}

