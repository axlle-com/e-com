<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\Catalog\Document\Coming\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentBase;
use App\Common\Models\Catalog\Document\Financial\DocumentFinInvoice;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Catalog\Document\Reservation\DocumentReservation;
use App\Common\Models\Catalog\Document\ReservationCancel\DocumentReservationCancel;
use App\Common\Models\Catalog\Document\Sale\DocumentSale;
use App\Common\Models\Catalog\Document\WriteOff\DocumentWriteOff;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DocumentAjaxController extends BackendController
{
    private string $title;
    private array $post;
    private mixed $models;
    private mixed $model;
    private string $type;

    ##### index #####

    public function indexDocumentRoute(): Response|JsonResponse
    {
        if ($this->post = $this->validation(['type' => 'required|string'])) {
            $this->type = $this->post['type'];
            $method = Str::camel($this->type);
            if (method_exists($this, $method)) {
                return $this->{$method}();
            }

            return $this->badRequest()->error();
        }

        return $this->error();
    }

    public function coming(): Response|JsonResponse
    {
        $this->models = DocumentComing::filterAll($this->post);

        return $this->getIndexData(DocumentComing::class);
    }

    private function getIndexData($class): Response|JsonResponse
    {
        $view = $this->view(
            'backend.ajax.document',
            ['errors' => $this->getErrors(), 'breadcrumb' => (new $class)->breadcrumbAdmin('index'),
             'models' => $this->models, 'post' => $this->post, 'isAjax' => true,
             'keyDocument' => DocumentBase::keyDocument($class),]
        )->render();
        $data = ['view' => _clear_soft_data($view)];

        return $this->setData($data)->response();
    }

    public function order(): Response|JsonResponse
    {
        $this->models = DocumentOrder::filterAll($this->post);

        return $this->getIndexData(DocumentOrder::class);
    }

    public function sale(): Response|JsonResponse
    {
        $this->models = DocumentSale::filterAll($this->post);

        return $this->getIndexData(DocumentSale::class);
    }

    public function writeOff(): Response|JsonResponse
    {
        $this->models = DocumentWriteOff::filterAll($this->post);

        return $this->getIndexData(DocumentWriteOff::class);
    }

    public function reservationCancel(): Response|JsonResponse
    {
        $this->models = DocumentReservationCancel::filterAll($this->post);

        return $this->getIndexData(DocumentReservationCancel::class);
    }

    public function reservation(): Response|JsonResponse
    {
        $this->models = DocumentReservation::filterAll($this->post);

        return $this->getIndexData(DocumentReservation::class);
    }

    ##### save #####

    public function saveDocumentRoute(): Response|JsonResponse
    {
        if ($this->post = $this->validation(['type' => 'required|string'])) {
            if ($this->post = $this->validation(DocumentBase::rules())) {
                $this->type = $this->post['type'];
                $method = 'save'.Str::studly($this->type);
                if (method_exists($this, $method)) {
                    return $this->{$method}();
                }

                return $this->badRequest()->error();
            }
        }

        return $this->error();
    }

    public function saveOrder(): Response|JsonResponse
    {
        $this->model = DocumentOrder::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentOrder::class);
    }

    private function getSaveData($class): Response|JsonResponse
    {
        $view = $this->view(
            'backend.document.update', ['errors' => $this->getErrors(), 'breadcrumb' => (new $class)->breadcrumbAdmin(),
                                        'title' => 'Документ '.DocumentBase::titleDocument(
                                                $class
                                            ).' №'.$this->model->id, 'model' => $this->model,
                                        'post' => $this->request(), 'keyDocument' => DocumentBase::keyDocument($class),]
        )->renderSections()['content'];
        $data = ['view' => _clear_soft_data($view),
                 'url'  => '/admin/catalog/document/'.$this->type.'-update/'.$this->model->id,];

        return $this->setData($data)->response();
    }

    public function saveComing(): Response|JsonResponse
    {
        $this->model = DocumentComing::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentComing::class);
    }

    public function saveSale(): Response|JsonResponse
    {
        $this->model = DocumentSale::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentSale::class);
    }

    public function saveWriteOff(): Response|JsonResponse
    {
        $this->model = DocumentWriteOff::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentWriteOff::class);
    }

    public function saveReservationCancel(): Response|JsonResponse
    {
        $this->model = DocumentReservationCancel::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentReservationCancel::class);
    }

    public function saveReservation(): Response|JsonResponse
    {
        $this->model = DocumentReservation::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);

            return $this->error($this::ERROR_BAD_REQUEST);
        }

        return $this->getSaveData(DocumentReservation::class);
    }

    ##### posting #####

    public function postingDocumentRoute(): Response|JsonResponse
    {
        if ($this->post = $this->validation(['type' => 'required|string'])) {
            if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
                $this->type = $this->post['type'];
                $method = 'posting'.Str::studly($this->type);
                if (method_exists($this, $method)) {
                    return $this->{$method}();
                }

                return $this->badRequest()->error();
            }
        }

        return $this->error();
    }

    public function postingOrder(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentOrder::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentOrder::class);
        }

        return $this->error();
    }

    private function getPostingData($class): Response|JsonResponse
    {
        $view = $this->view(
            'backend.document.view', ['errors' => $this->getErrors(), 'breadcrumb' => (new $class)->breadcrumbAdmin(),
                                      'title' => 'Документ '.DocumentBase::titleDocument($class).' №'.$this->model->id,
                                      'model' => $this->model, 'post' => $this->request(),
                                      'keyDocument' => DocumentBase::keyDocument($class),]
        )->renderSections()['content'];
        $data = ['view' => _clear_soft_data($view),
                 'url'  => '/admin/catalog/document/'.$this->type.'-update/'.$this->model->id,];

        return $this->setData($data)->response();
    }

    public function postingComing(): Response|JsonResponse
    {
        $rule = DocumentBase::rules('posting');
        $rule['contents.*.price_out'] = 'required|numeric|min:1';
        if ($this->post = $this->validation($rule)) {
            $this->model = DocumentComing::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentComing::class);
        }

        return $this->error();
    }

    public function postingSale(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentSale::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentSale::class);
        }

        return $this->error();
    }

    public function postingWriteOff(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentWriteOff::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentWriteOff::class);
        }

        return $this->error();
    }

    public function postingReservationCancel(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentReservationCancel::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentReservationCancel::class);
        }

        return $this->error();
    }

    public function postingReservation(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentReservation::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);

                return $this->error($this::ERROR_BAD_REQUEST);
            }

            return $this->getPostingData(DocumentReservation::class);
        }

        return $this->error();
    }

    ##### other #####

    public function loadDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|integer'])) {
            $model = CatalogDocument::filter()->where(CatalogDocument::table('id'), $post['id'])->first();
            $view = $this->view('backend.ajax.document_content_load', ['model' => $model,])->render();
            $target = $model->subject_title ?? 'Документ';
            $target .= ' №';
            $target .= $model->id ?? 0;
            $target .= ' от ';
            $target .= (isset($model['created_at']) ? _unix_to_string_moscow($model['created_at']) : '');
            $data = ['view' => _clear_soft_data($view), 'target' => $target,];

            return $this->setData($data)->response();
        }

        return $this->error();
    }

    public function deleteDocumentContent(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|numeric', 'model' => 'required|string',])) {
            $class = BaseModel::className($post['model']);
            $model = $class::deleteContent($post['id']);
            if ( ! $model) {
                return $this->badRequest()->error();
            }

            return $this->setMessage('Позиция удалена')->response();
        }

        return $this->error();
    }

    public function deleteDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|numeric', 'model' => 'required|string',])) {
            if (DocumentBase::deleteById($post)) {
                $this->setMessage('Документ успешно удален!');

                return $this->response();
            }

            return $this->badRequest()->error();
        }

        return $this->error();
    }

    public function getProduct(): Response|JsonResponse
    {
        if ($post = $this->validation(['q' => 'required|string'])) {
            $models = CatalogProduct::search($post['q']);

            return $this->setData($models)->response();
        }

        return $this->error();
    }

    public function createWriteOffFromFront(): Response|JsonResponse
    {
        if ($post = $this->validation([])) {
            $data = ['contents' => [['catalog_product_id' => $post['catalog_product_id'],
                                     'quantity'           => $post['quantity'],],],];
            $model = DocumentWriteOff::createOrUpdate($data)->posting();
            if ($errors = $model->getErrors()) {
                return $this->setErrors($errors)->error($this::ERROR_BAD_REQUEST);
            }

            return $this->setMessage('Документ успешно создан и товар списан')->response();
        }

        return $this->error();
    }

    public function loadProduct(): Response|JsonResponse
    {
        $models = CatalogProduct::filter()->orderBy(CatalogProduct::table().'.created_at', 'desc')->paginate(30);
        $view = $this->view('backend.catalog.inc.product_index', ['models' => $models,])->render();
        $data = ['view' => _clear_soft_data($view),];

        return $this->setData($data)->response();
    }

    public function loadProductContent(): Response|JsonResponse
    {
        if ($post = $this->validation(['items' => 'required|array', 'items.*' => 'required|integer',])) {
            $coming = ! empty($post['document']) && $post['document'] === 'coming-update';
            $models = CatalogProduct::filter()->whereIn(CatalogProduct::table('id'), $post['items'])->get();
            $view = $this->view(
                'backend.document.inc.document_product_load', ['models' => $models, 'coming' => $coming,]
            )->render();
            $data = ['view' => _clear_soft_data($view),];

            return $this->setData($data)->response();
        }

        return $this->error();
    }

    public function invoiceFastCreate(): Response|JsonResponse
    {
        $rule = ['phone' => 'required|string', 'sum' => 'required|integer',];
        if ($post = $this->validation($rule)) {
            if ($err = DocumentFinInvoice::createFast($post)->getErrors()) {
                return $this->setData($err)->error(self::ERROR_BAD_REQUEST);
            }

            return $this->setMessage('Ссылка отправлена')->response();
        }

        return $this->error();
    }
}
