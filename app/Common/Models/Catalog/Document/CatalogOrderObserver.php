<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\BaseObserver;

class CatalogOrderObserver extends BaseObserver
{
    public function saved(CatalogOrder $model): void
    {
        $model->createDocument();
    }
}
