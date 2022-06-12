<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
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
                'view' => _clear_soft_data($view),
                'url' => '/admin/catalog/category-update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function indexCategory(int $id = null)
    {
        $title = 'Новая категория';
        $model = new CatalogCategory();
        /* @var $model \App\Common\Models\Catalog\Category\CatalogCategory */
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

    public function saveProduct(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogProduct::rules())) {
            $post['user_id'] = UserWeb::auth()->id;
            $model = CatalogProduct::createOrUpdate($post);
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
                'view' => _clear_soft_data($view),
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

    public function saveSortProduct()
    {
        $rule = [
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ];
        if ($post = $this->validation($rule)) {
            CatalogProduct::saveSort($post);
            return $this->response();
        }
        return $this->error();
    }

    public function addProperty(): Response|JsonResponse
    {
        $post = $this->request();
        $catalogProperties = CatalogProperty::withType()
            ->with(['units'])
            ->when($ids = $post['ids'] ?? null, static function ($query) use ($ids) {
                return $query->whereNotIn(CatalogProperty::table() . '.id', $ids);
            })
            ->get();
        $catalogPropertyUnits = CatalogPropertyUnit::all();
        $view = view('backend.catalog.inc.property', [
            'errors' => $this->getErrors(),
            'properties' => $catalogProperties,
            'units' => $catalogPropertyUnits,
        ])->render();
        $data = ['view' => _clear_soft_data($view),];
        return $this->setData($data)->response();
    }

    public function addPropertySelf(): Response|JsonResponse
    {
        $post = $this->request();
        if (!empty($post['property_id'])) {
            $model = CatalogProperty::withType()
                ->with(['units'])
                ->find($post['property_id']);
        }
        $catalogPropertyUnits = CatalogPropertyUnit::all();
        $catalogPropertyType = CatalogPropertyType::all();
        $view = view('backend.catalog.inc.property_self', [
            'errors' => $this->getErrors(),
            'units' => $catalogPropertyUnits,
            'types' => $catalogPropertyType,
            'model' => $model ?? null,
        ])->render();
        $data = ['view' => _clear_soft_data($view),];
        return $this->setData($data)->response();
    }

    public function savePropertySelf(): Response|JsonResponse
    {
        $rule = [
            'property_title' => 'required|string',
            'property_unit_id' => 'nullable|string',
            'catalog_property_type_id' => 'required|numeric',
        ];
        if ($post = $this->validation($rule)) {
            $catalogProperty = CatalogProperty::createOrUpdate($post);
            if ($catalogProperty->getErrors()) {
                return $this->badRequest()->error();
            }
            $catalogPropertyNew = CatalogProperty::withType()
                ->with(['units'])
                ->find($catalogProperty->id);
            return $this->setData($catalogPropertyNew->toArray())->response();
        }
        return $this->badRequest()->error();
    }

    public function deleteProperty(): Response|JsonResponse
    {
        $rules = [
            'id' => 'required|numeric',
            'model' => 'required|string',
        ];
        if ($post = $this->validation($rules)) {
            if (CatalogProduct::deleteProperty($post)) {
                return $this->response();
            }
            return $this->error();
        }
        return $this->error();
    }

    public function addCoupon(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogCoupon::rules('add'))) {
            $coupons = CatalogCoupon::addArray($post);
            if (!$coupons->getErrors()) {
                $view = view('backend.catalog.inc.coupon', [
                    'coupons' => $coupons->getCollection(),
                ]);
                $this->setData(['view' => _clear_soft_data($view)]);
                return $this->response();
            }
            return $this->setErrors($coupons->getErrors())->badRequest()->error();
        }
        return $this->error();
    }

    public function deleteCoupon(): Response|JsonResponse
    {

        if ($post = $this->validation(CatalogCoupon::rules('delete'))) {
            $arr = CatalogCoupon::deleteArray($post);
            return $this->setData(['ids' => $arr])->response();
        }
        return $this->error();
    }

    public function giftCoupon(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogCoupon::rules('delete'))) {
            if ($err = CatalogCoupon::giftArray($post)->getErrors()) {
                return $this->setErrors($err)->badRequest()->error();
            }
            return $this->response();
        }
        return $this->error();
    }
}
