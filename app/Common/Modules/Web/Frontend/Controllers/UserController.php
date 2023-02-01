<?php

namespace Web\Frontend\Controllers;

use App\Common\Components\Mail\AccountActivation;
use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;
use App\Common\Models\User\VerificationToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class UserController extends WebController
{
    public function profile()
    {
        $user = UserWeb::auth();
        return _view('user.profile', ['user' => $user]);
    }

    public function activateToken()
    {
        /** @var UserWeb $user */
        $post = $this->request();
        if (!empty($post['value'])) {
            $value = $post['value'];
            $user = UserWeb::query()->whereHas('token', static function (Builder $query) use ($value) {
                $query->where('token', $value)->where('expired_at', '>', time());
            })->first();
            if ($user && $user->activateWithMail()) {
                return redirect('/user/profile')->with('success', ['Активация прошла успешно']);
            }
            abort(404);
        }
        abort(404);
    }

    public function activate()
    {
        /** @var UserWeb $user */
        if (($user = UserWeb::auth()) && (new VerificationToken)->new($user)) {
            Mail::to($user->email)->send(new AccountActivation($user));
            return redirect('/user/profile')->with('success', ['Проверьте ваш почтовый ящик, если письма нет проверьте папку спам']);
        }
        return redirect('/user/profile')->with('error', ['Произошла ошибка при отправке сообщения']);
    }

    public function restorePassword()
    {
        if ($user = UserWeb::auth()) {
            abort(404);
        }
        return _view('user.restore_password');
    }

    public function resetPassword()
    {
        /** @var UserWeb $user */
        $post = $this->request();
        if (!empty($post['value'])) {
            $value = $post['value'];
            $user = UserWeb::query()->whereHas('tokenResetPassword', static function (Builder $query) use ($value) {
                $query->where('token', $value)->where('expired_at', '>', time());
            })->first();
            if ($user && $user->login()) {
                return _view('user.reset_password');
            }
            abort(404);
        }
        abort(404);
    }
}
