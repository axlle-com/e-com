<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;

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
                ->with(['manyGalleryWithImages'])
                ->where('id', $id)
                ->first();
            if (!$model) {
                abort(404);
            }
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

    public function deleteCategory(int $id = null)
    {
        /* @var $model CatalogCategory */
        if ($id && $model = CatalogCategory::query()->with(['manyGalleryWithImages'])->where('id', $id)->first()) {
            $model->delete();
        }
        return back();
    }

    public function indexCatalogProduct()
    {
        $post = $this->request();
        $title = 'Список товаров';
        $models = CatalogProduct::filter($post)
            ->orderBy(CatalogProduct::table() . '.created_at', 'desc')
            ->paginate(30);
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
                    'widgetTabs',
                    'manyGalleryWithImages',
                ])
                ->where('id', $id)
                ->first()
        ) {
            $title .= ' ' . $model->title;
        }
        if (!$model) {
            abort(404);
        }
        $catalogProperties = CatalogProperty::query()->with(['propertyType', 'units'])->get();
        $catalogPropertyUnits = CatalogPropertyUnit::all();
        return view('backend.catalog.product_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'propertiesModel' => $model->getProperty(),
            'properties' => $catalogProperties,
            'units' => $catalogPropertyUnits,
            'post' => $this->request(),
        ]);
    }

    public function deleteCatalogProduct(int $id = null)
    {
        /* @var $model CatalogProduct */
        if ($id && $model = CatalogProduct::query()->with(['manyGalleryWithImages'])->where('id', $id)->first()) {
            $model->delete();
        }
        return back();
    }

    public function indexCoupon()
    {
        $post = $this->request();
        $title = 'Список купонов';
        $coupons = CatalogCoupon::query()->orderBy('created_at','desc')->paginate(30);
        return view('backend.catalog.coupon', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
            'title' => $title,
            'coupons' => $coupons,
            'post' => $post,
        ]);
    }
}
