<?php

namespace Web\Backend\Controllers;

use Illuminate\Http\Request;
use App\Common\Models\User\UserWeb;
use App\Common\Http\Controllers\WebController;

class UserController extends WebController
{
    public function profile(Request $request)
    {
        $user = UserWeb::auth();
        return view('backend.user.update', [
            'model' => $user,
            'title' => 'Пользователь: ' . $user->first_name,
        ]);
    }
}
