<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthController extends WebController
{
    public function login()
    {
        if (($post = $this->validation(User::RULE_VALIDATION_LOGIN)) && Auth::attempt($post, true)) {
            return redirect(RouteServiceProvider::HOME);
        }
        return view('backend.login', ['post' => $post])->with('status', $this->getMessage());
    }

    public function logout()
    {
        Auth::logout();
        return redirect(RouteServiceProvider::HOME);
    }
}
