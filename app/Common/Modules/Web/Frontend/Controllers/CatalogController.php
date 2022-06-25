<?php

namespace Web\Frontend\Controllers;

use App\Common\Components\Mail\NotifyAdmin;
use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogPaymentStatus;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Document\DocumentOrder;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\Status;
use App\Common\Models\Page\Page;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\Mail;

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

    public function orderConfirm()
    {
        $user = UserWeb::auth();
        $model = DocumentOrder::getByUser($user->id ?? null);
        if (!$model) {
            abort(404);
        }
        $post = $this->request();
        return view('frontend.catalog.order_confirm', [
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
                    $this->setErrors($order->paymentData['ErrorMessage']);
                } else {
                    $this->setErrors('Произошла ошибка, свяжитесь по контактному номеру телефона');
                }
                $order->rollBack();
            }
        }
        $this->setErrors('Произошла не известная ошибка, свяжитесь по контактному номеру телефона');
        return redirect('/user/order')->with(['error' => $this->getErrors(), 'message' => 'Телефон: +7(928)425-25-22']);
    }

    public function orderPayConfirm()
    {
        $post = $this->request();
        $user = UserWeb::auth();
        if ($user) {
            /* @var $order DocumentOrder */
            $order = DocumentOrder::filter()
                ->with(['contents'])
                ->join(CatalogPaymentStatus::table(), CatalogPaymentStatus::table('id'), '=', DocumentOrder::table('catalog_payment_status_id'))
                ->where(DocumentOrder::table('status'), Status::STATUS_POST)
                ->where(CatalogPaymentStatus::table('key'), 'paid')
                ->orderByDesc('updated_at')
                ->first();
            if (!$order) {
                $this->setErrors('Произошла ошибка, свяжитесь по контактному номеру телефона');
            } else {
                $success = true;
            }
        } else {
            abort(404);
        }
        return view('frontend.catalog.order_confirm', [
            'errors' => $this->getErrors(),
            'message' => $this->message ?? null,
            'breadcrumb' => (new CatalogProduct)->breadcrumbAdmin('index'),
            'post' => $post,
            'model' => $order,
            'success' => $success ?? false,
        ]);
    }
}
