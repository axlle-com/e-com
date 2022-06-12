<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Main\BaseObserver;

class CatalogProductObserver extends BaseObserver
{
    public function deleting(CatalogProduct $model): bool
    {
        if ($model->is_published) {
            return false;
        }
        $model->deleteImage();
        $model->detachManyGallery();
        $model->deleteCatalogProductWidgets();
        $model->deleteProperties();
        return true;
    }

    public function saved(CatalogProduct $model): void
    {
        $model->createDocument();
    }
}
