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
use App\Common\Models\Main\Status;

class DocumentController extends BackendController
{
    private string $title;
    private array $post;
    private mixed $models;
    private mixed $model;

    ##### index #####

    public function indexDocumentOrder()
    {
        $this->post = $this->request();
        $this->title = 'Список заказов';
        $this->models = DocumentOrder::filterAll($this->post);
        return $this->getIndexData(DocumentOrder::class);
    }

    private function getIndexData($class)
    {
        return $this->view('backend.document.' . $class::$pageIndex, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin('index'),
            'title' => $this->title,
            'models' => $this->models,
            'post' => $this->post,
            'keyDocument' => DocumentBase::keyDocument($class),
        ]);
    }

    public function indexDocumentFinInvoice()
    {
        $this->post = $this->request();
        $this->title = 'Список счетов на оплату';
        $this->models = DocumentFinInvoice::filterAll($this->post);
        return $this->getIndexData(DocumentFinInvoice::class);
    }

    public function indexDocumentComing()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Поступление"';
        $this->models = DocumentComing::filterAll($this->post);
        return $this->getIndexData(DocumentComing::class);
    }

    public function indexDocumentSale()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Продажа"';
        $this->models = DocumentSale::filterAll($this->post);
        return $this->getIndexData(DocumentSale::class);
    }

    public function indexDocumentWriteOff()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Списание"';
        $this->models = DocumentWriteOff::filterAll($this->post);
        return $this->getIndexData(DocumentWriteOff::class);
    }

    public function indexDocumentReservation()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Резерв"';
        $this->models = DocumentReservation::filterAll($this->post);
        return $this->getIndexData(DocumentReservation::class);
    }

    public function indexDocumentReservationCancel()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Снятие с резерва"';
        $this->models = DocumentReservationCancel::filterAll($this->post);
        return $this->getIndexData(DocumentReservationCancel::class);
    }

    ##### update #####

    public function updateDocumentOrder(int $id = null)
    {
        $title = 'Новый заказ';
        $model = new DocumentOrder();
        /** @var $model DocumentOrder */
        if ($id) {
            $model = DocumentOrder::filter()->where(DocumentOrder::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Заказ №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentOrder::class);
    }

    private function getUpdateData($class)
    {
        $data = [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin('index'),
            'title' => $this->title,
            'model' => $this->model,
            'keyDocument' => DocumentBase::keyDocument($class),
        ];
        if ($this->model->status === Status::STATUS_POST) {
            return $this->view('backend.document.' . $class::$pageView, $data);
        }
        return $this->view('backend.document.' . $class::$pageUpdate, $data);
    }

    public function updateDocumentComing(int $id = null)
    {
        $title = 'Новый документ поступление';
        $model = new DocumentComing();
        /** @var $model DocumentComing */
        if ($id) {
            $model = DocumentComing::filter()->where(DocumentComing::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ поступление №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentComing::class);
    }

    public function updateDocumentSale(int $id = null)
    {
        $title = 'Новый документ продажа';
        $model = new DocumentSale();
        /** @var $model DocumentComing */
        if ($id) {
            $model = DocumentSale::filter()->where(DocumentSale::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ продажа №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentSale::class);
    }

    public function updateDocumentWriteOff(int $id = null)
    {
        $title = 'Новый документ списание';
        $model = new DocumentWriteOff();
        /** @var $model DocumentWriteOff */
        if ($id) {
            $model = DocumentWriteOff::filter()->where(DocumentWriteOff::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ списание №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentWriteOff::class);
    }

    public function updateDocumentReservation(int $id = null)
    {
        $title = 'Новый документ резервирование';
        $model = new DocumentReservation();
        /** @var $model DocumentReservation */
        if ($id) {
            $model = DocumentReservation::filter()->where(DocumentReservation::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ резервирование №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentReservation::class);
    }

    public function updateDocumentReservationCancel(int $id = null)
    {
        $title = 'Новый документ снятие с резерва';
        $model = new DocumentReservationCancel();
        /** @var $model DocumentReservationCancel */
        if ($id) {
            $model = DocumentReservationCancel::filter()->where(DocumentReservationCancel::table('id'), $id)->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ снятие с резерва №' . $model->id;
        }
        $this->title = $title;
        $this->model = $model;
        return $this->getUpdateData(DocumentReservationCancel::class);
    }
}
