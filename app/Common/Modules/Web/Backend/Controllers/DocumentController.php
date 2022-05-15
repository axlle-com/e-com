<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\CatalogDocument;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;

class DocumentController extends WebController
{
    public function indexDocument()
    {
        $post = $this->request();
        $title = 'Список документов';
        $models = CatalogDocument::filterAll($post);
        return view('backend.catalog.document', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }
}
