<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Main\BaseObserver;

class PostCategoryObserver extends BaseObserver
{
    public function deleting(PostCategory $model): void
    {
        $model->deleteImage();
        $model->detachManyGallery();
        $model->deleteCategories();
        $model->deletePosts();
    }
}
