<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Main\BaseObserver;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;

class PostObserver extends BaseObserver
{
    public function creating(Post $post): void
    {
        if ((!$user = UserWeb::auth()) && (!$user = UserRest::auth()) && (!$user = UserApp::auth())) {
            return;
        }
        $post->user_id = $user->id;
    }

    public function deleting(Post $post): void
    {
        $post->deleteImage();
        $post->detachManyGallery();
    }
}
