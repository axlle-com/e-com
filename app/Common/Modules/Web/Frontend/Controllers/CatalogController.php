<?php

namespace App\Common\Modules\Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Page\Page;

class CatalogController extends WebController
{
    public function index()
    {
        /* @var $model Page */
        $post = $this->request();
        $model = Page::filter()->where('ax_page_type.resource', 'ax_catalog_category')->first();
        $title = $model->title ?? '';
        $categories = CatalogCategory::filter()->with('products')->get();
        return view('frontend.catalog.index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'categories' => $categories,
            'post' => $post,
        ]);
    }

    public function route($alias)
    {
        if ($model = CatalogProduct::filter()->with('manyGalleryWithImages')->where(CatalogProduct::table() . '.alias', $alias)->first()) {
            return $this->catalogProduct($model);
        }
        if ($model = CatalogCategory::filter()->where(CatalogCategory::table() . '.alias', $alias)->first()) {
            return $this->category($model);
        }
        abort(404);
    }

    public function category($model)
    {
        /* @var $model CatalogCategory */
        $post = $this->request();
        $title = $model->title;
        $products = $model->catalogProducts;
        $page = $model->render_name ? 'render.' . $model->render_name : 'catalog.category';
        return view('frontend.' . $page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'products' => $products,
            'post' => $post,
        ]);
    }

    public function catalogProduct($model)
    {
        /* @var $model CatalogProduct */
        $post = $this->request();
        $title = $model->title;
        $page = $model->render_name ? 'render.' . $model->render_name : 'catalog.product';
        return view('frontend.' . $page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ]);
    }
}
