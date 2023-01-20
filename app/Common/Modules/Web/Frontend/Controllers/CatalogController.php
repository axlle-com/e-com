<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Document\Financial\DocumentFinInvoice;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\Status;
use App\Common\Models\Page\Page;
use App\Common\Models\User\UserWeb;

class CatalogController extends WebController
{
    public function index()
    {
        /* @var $model Page */
        $post = $this->request();
        $title = $model->title ?? '';
        $categories = CatalogCategory::filter()->with('productsRandom')->get();
        return _view('catalog.index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'categories' => $categories,
            'post' => $post,
        ]);
    }

    public function route($alias)
    {
        if ($model = CatalogProduct::inStock()->where(CatalogProduct::table('alias'), $alias)->with([
            'manyGalleryWithImages',
            'widgetTabs',
            'comments',
        ])->first()) {
            return $this->catalogProduct($model);
        }
        if ($model = CatalogCategory::filter()
                                    ->where(CatalogCategory::table('alias'), $alias)
                                    ->with('products')
                                    ->first()) {
            return $this->category($model);
        }
        abort(404);
    }

    public function catalogProduct($model)
    {
        /* @var $model CatalogProduct */
        $post = $this->request();
        $title = $model->title;
        $page = $model->render_name ? 'render.' . $model->render_name : 'catalog.product';
        return _view($page, [
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
        $products = $model->products;
        $page = $model->render_name ? 'render.' . $model->render_name : 'catalog.category';
        return _view($page, [
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
        return _view('catalog.basket', [
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
        return _view('catalog.order', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function orderConfirm()
    {
        $user = UserWeb::auth();
        $model = DocumentOrder::getByUser($user->id ?? null);
        if (!$model) {
            abort(404);
        }
        $post = $this->request();
        return _view('catalog.order_confirm', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'post' => $post,
            'model' => $model,
        ]);
    }

    public function orderPay()
    {
        $post = $this->request();
        $user = UserWeb::auth();
        if ($user && !empty($post['orderId'])) {
            /* @var $order DocumentOrder */
            $order = DocumentOrder::filter()
                                  ->where(DocumentOrder::table('payment_order_id'), $post['orderId'])
                                  ->where(DocumentOrder::table('status'), Status::STATUS_POST)
                                  ->first();
            if ($order) {
                if ($order->checkPay()) {
                    if ($order->sale()->getErrors()) {
                        $order->notifyAdmin('Не сформировался документ продажи по одеру:' . $order->uuid);
                    }
                    $order->notify();
                    return redirect('/user/order-pay-confirm');
                }
                if ($order->paymentData) {
                    $this->setErrors(_Errors::error($order->paymentData['ErrorMessage'], $this));
                } else {
                    $this->setErrors(_Errors::error('Произошла ошибка, свяжитесь по контактному номеру телефона', $this));
                }
                $order->rollBack();
            }
        }
        $this->setErrors(_Errors::error('Произошла ошибка, свяжитесь по контактному номеру телефона', $this));
        return redirect('/user/order')->with([
            'error' => $this->getErrors(),
            'message' => 'Телефон: +7(928)425-25-22',
        ]);
    }

    public function orderPayConfirm()
    {
        $post = $this->request();
        $user = UserWeb::auth();
        if ($user) {
            if (!empty($post['order'])) {
                $order = DocumentOrder::getByUuid($user->id, $post['order']);
            } else {
                $order = DocumentOrder::getLastPaid($user->id);
                if (!$order) {
                    session(['error' => 'Оплаченных ордеров нет']);
                } else {
                    $success = true;
                }
            }
        } else {
            abort(404);
        }
        return _view('catalog.order_confirm', [
            'errors' => $this->getErrors(),
            'message' => $this->message ?? null,
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'post' => $post,
            'model' => $order ?? null,
            'success' => $success ?? false,
            'info' => true,
        ]);
    }

    public function invoicePay()
    {
        $post = $this->request();
        if (!empty($post['orderId'])) {
            /* @var $order DocumentFinInvoice */
            $order = DocumentFinInvoice::query()
                                       ->where(DocumentFinInvoice::table('payment_order_id'), $post['orderId'])
                                       ->where(DocumentFinInvoice::table('status'), Status::STATUS_POST)
                                       ->first();
            if ($order && $order->checkPay()) {
                session([
                    'success' => 'Оплата прошла успешно',
                    'message' => 'Телефон: +7(928)425-25-22',
                ]);
                return _view('catalog.invoice');
            }
        }
        $this->setErrors(_Errors::error('Произошла ошибка, свяжитесь по контактному номеру телефона', $this));
        session([
            'error' => $this->getErrors()?->getErrors(),
            'message' => 'Телефон: +7(928)425-25-22',
        ]);
        return _view('catalog.invoice');
    }
}
