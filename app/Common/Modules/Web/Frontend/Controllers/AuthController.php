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
        if ($post = $this->validation(UserWeb::rules('login'))) {
            if (UserWeb::validate($post)) {
                return redirect(RouteServiceProvider::HOME);
            }
            dd($post);
        }
        return view('backend.login', ['post' => $post]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(RouteServiceProvider::HOME);
    }
}

