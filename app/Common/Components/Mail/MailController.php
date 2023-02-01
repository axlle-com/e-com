<?php

namespace App\Common\Components\Mail;

use App\Common\Http\Controllers\Controller;
use App\Common\Models\User\UserGuest;
use App\Common\Models\User\UserToken;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\Mail;

/**
 * @property UserWeb $user Пользователь
 */
class MailController extends Controller
{
    public function activate()
    {
        /** @var UserWeb $user */
        if (($user = UserWeb::auth()) && (new UserToken)->new($user)) {
            Mail::to($user->email)->send(new AccountActivation($user));
        }

        //        Mail::raw('Привет', static function($message){
        //            $message->from(env('MAIL_USERNAME', ''), 'Vasya Pupkin');
        //            $message->to('axlle@mail.ru');
        //        });
    }

    public function contact()
    {

    }
}
