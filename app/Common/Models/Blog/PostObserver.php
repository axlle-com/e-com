<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Main\BaseObserver;

class PostObserver extends BaseObserver
{
    public function deleting(Post $post): void
    {
        $post->deleteImage();
        $post->detachManyGallery();
    }
}
