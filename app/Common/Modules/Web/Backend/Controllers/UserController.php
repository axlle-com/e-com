<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
