<?php

namespace App\Common\Models\Catalog\Document;

class CatalogDocumentContentObserver
{
    public function created(CatalogDocumentContent $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function updated(CatalogDocumentContent $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function deleted(CatalogDocumentContent $model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }
}
