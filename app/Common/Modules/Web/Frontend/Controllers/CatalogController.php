<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Page\Page;
use App\Common\Models\User\UserWeb;

class CatalogController extends WebController
{
    public function index()
    {
        /* @var $model Page */
        $post = $this->request();
        $model = Page::filter()->where('ax_page_type.resource', 'ax_catalog_category')->first();
        $title = $model->title ?? '';
        $categories = CatalogCategory::filter()->with('productsRandom')->get();
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
        if ($model = CatalogProduct::inStock()->where(CatalogProduct::table() . '.alias', $alias)->with(['manyGalleryWithImages', 'widgetTabs'])->first()) {
            return $this->catalogProduct($model);
        }
        if ($model = CatalogCategory::filter()->where(CatalogCategory::table() . '.alias', $alias)->with('products')->first()) {
            return $this->category($model);
        }
        abort(404);
    }

    public function catalogProduct($model)
    {
        /* @var $model \App\Common\Models\Catalog\Product\CatalogProduct */
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

    public function basket()
    {
        $post = $this->request();
        $user = UserWeb::auth();
        $models = CatalogBasket::getBasket($user->id ?? null);
        if (!$models) {
            abort(404);
        }
        return view('frontend.catalog.basket', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function order()
    {
        $post = $this->request();
        $user = UserWeb::auth();
        $models = CatalogBasket::getBasket($user->id ?? null);
        if (!$models) {
            abort(404);
        }
        return view('frontend.catalog.order', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'models' => $models,
            'post' => $post,
        ]);
    }
}
