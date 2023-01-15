<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Comment\Comment;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\User\UserGuest;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AjaxController extends WebController
{
    public function addComment(): Response|JsonResponse
    {
        if ($post = $this->validation(Comment::rules())) {
            if ($user = $this->getUser()) {
                $post['person_id'] = $user->id;
                $post['person'] = $user->getTable();
            } else if ($post['email']) {
                if (UserWeb::query()->where('email', $post['email'])->first()) {
                    $this->setErrors(_Errors::error('Авторизуйтесь пожалуйста', $this));
                    return $this->badRequest()->error();
                }
                $user = UserGuest::query()->where('email', $post['email'])->first();
                if ($user || (($user = UserGuest::create($post)) && !$user->getErrors())) {
                    $post['person_id'] = $user->id;
                    $post['person'] = $user->getTable();
                } else {
                    $this->setErrors(_Errors::error($user->getErrors()?->getErrors(), $this));
                    return $this->badRequest()->error();
                }
            } else {
                $format = 'Поле %s обязательно для заполнения';
                $this->setErrors(_Errors::error(['email' => sprintf($format, 'email')], $this));
                return $this->badRequest()->error();
            }
            $comment = Comment::create($post);
            if ($comment->getErrors()) {
                $this->setErrors(_Errors::error($comment->getErrors()?->getErrors(), $this)); # TODO: Redo saving errors!!!
                return $this->badRequest()->error();
            }
            $view = _view('ajax.comment', [
                'model' => $comment,
            ])->render();
            $this->setMessage('Комментарий добавлен');
            return $this->setData(['view' => _clear_soft_data($view)])->gzip();
        }
        return $this->error();
    }

    public function openComment(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|integer'])) {
            $view = Comment::getChildrenCommentArray($post['id']);
            $this->setMessage('Комментарии открыты');
            return $this->setData(['view' => _clear_soft_data($view)])->gzip();
        }
        return $this->error();
    }
}
