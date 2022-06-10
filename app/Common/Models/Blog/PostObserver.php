<?php

namespace App\Common\Models\Blog;

class PostObserver
{
    public function created(Post $post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }

    public function updated(Post $post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }

    public function deleting(Post $post): void
    {
        $post->deleteImage();
        $post->detachManyGallery();
    }

    public function deleted(Post $post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }
}
