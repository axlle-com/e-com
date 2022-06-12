<?php

namespace App\Common\Models\Catalog\Category;

use App\Common\Models\Main\BaseObserver;

class CatalogCategoryObserver extends BaseObserver
{
    public function deleting(CatalogCategory $model): void
    {
        $model->deleteImage();
        $model->detachManyGallery();
        $model->deleteCatalogCategories();
        $model->deleteCatalogProducts();
    }
}
