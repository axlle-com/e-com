<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;

class CatalogController extends WebController
{
    public function indexCategory()
    {
        $post = $this->request();
        $title = 'Список категорий';
        $models = CatalogCategory::filterAll($post);
        return view('backend.catalog.category_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updateCategory(int $id = null)
    {
        $title = 'Новая категория';
        $model = new CatalogCategory();
        /* @var $model CatalogCategory */
        if ($id) {
            $model = CatalogCategory::query()
                ->with(['galleryWithImages'])
                ->where('id', $id)
                ->first();
            $title = 'Категория ' . $model->title;
        }
        return view('backend.catalog.category_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function indexCatalogProduct()
    {
        $post = $this->request();
        $title = 'Список товаров';
        $models = CatalogProduct::filterAll($post);
        return view('backend.catalog.product_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updateCatalogProduct(int $id = null)
    {
        $title = 'Товар';
        $model = new CatalogProduct();
        /* @var $model CatalogProduct */
        if ($id
            && $model = CatalogProduct::query()
                ->with([
                    'catalogProductWidgetsWithContent',
                    'galleryWithImages',
                ])
                ->where('id', $id)
                ->first()
        ) {
            $title .= ' ' . $model->title;
        }
        return view('backend.catalog.product_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }
}
