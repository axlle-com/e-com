<?php

namespace App\Common\Models\Blog;

class PostCategoryObserver
{
    public function created(PostCategory $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function updated(PostCategory $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function deleting(PostCategory $model): void
    {
        $model->deleteImage();
        $model->detachManyGallery();
        $model->deleteCategories();
        $model->deletePosts();
    }

    public function deleted(PostCategory $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }
}
