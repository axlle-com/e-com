<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CatalogAjaxController extends WebController
{
    public function saveCategory(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogCategory::rules())) {
            $model = CatalogCategory::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $view = view('backend.catalog.category_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin(),
                'title' => 'Категория ' . $model->title,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => $view,
                'url' => '/admin/catalog/category-update/' . $model->id,
            ];
            return $this->setData($data)->gzip();
        }
        return $this->error();
    }

    public function indexCategory(int $id = null)
    {
        $title = 'Новая категория';
        $model = new CatalogCategory();
        /* @var $model CatalogCategory */
        if ($id && $model = CatalogCategory::query()->where('id', $id)->first()) {
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

    public function saveProduct(): JsonResponse
    {
        if ($post = $this->validation(CatalogProduct::rules())) {
            $post['user_id'] = UserWeb::auth()->id;
            $model = CatalogProduct::createOrUpdate($post);
            $propertiesModel = $model->getProperty();
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $catalogProperties = CatalogProperty::query()->with(['propertyType', 'units'])->get();
            $catalogPropertyUnits = CatalogPropertyUnit::all();
            $view = view('backend.catalog.product_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
                'title' => 'Категория ' . $model->title,
                'model' => $model,
                'propertiesModel' => $model->getProperty(),
                'properties' => $catalogProperties,
                'units' => $catalogPropertyUnits,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => $view,
                'url' => '/admin/catalog/product-update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function indexProduct(int $id = null)
    {
        $title = 'Статья';
        $model = new CatalogProduct();
        /* @var $model CatalogProduct */
        if ($id && $model = CatalogProduct::query()->where('id', $id)->first()) {
            $title .= ' ' . $model->title;
        }
        return view('backend.catalog.post_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function addProperty(): Response|JsonResponse
    {
        $catalogProperties = CatalogProperty::query()->with(['propertyType','units'])->get();
        $catalogPropertyUnits = CatalogPropertyUnit::all();
        $view = view('backend.catalog.inc.property', [
            'errors' => $this->getErrors(),
            'properties' => $catalogProperties,
            'units' => $catalogPropertyUnits,
        ])->render();
        $data = [
            'view' => $view,
        ];
        return $this->setData($data)->gzip();
    }
}
