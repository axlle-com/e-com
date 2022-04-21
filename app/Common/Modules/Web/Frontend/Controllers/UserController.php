<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;

class UserController extends WebController
{
    public function profile()
    {
        $user = UserWeb::auth();
        return view('frontend.user.profile',['user' => $user]);
    }
}
