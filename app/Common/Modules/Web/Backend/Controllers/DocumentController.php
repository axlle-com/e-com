<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Main\Status;

class DocumentController extends WebController
{
    private string $title;
    private array $post;
    private mixed $models;
    private array $data = [];

    private function getIndexData($class)
    {
        return view('backend.document.document', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin('index'),
            'title' => $this->title,
            'models' => $this->models,
            'post' => $this->post,
            'keyDocument' => DocumentBase::keyDocument($class),
        ]);
    }

    public function indexDocumentComing()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Поступление"';
        $this->models = DocumentComing::filterAll($this->post);
        return $this->getIndexData(DocumentComing::class);
    }

    public function indexDocumentWriteOff()
    {
        $this->post = $this->request();
        $this->title = 'Список документов "Списание"';
        $this->models = DocumentWriteOff::filterAll($this->post);
        return $this->getIndexData(DocumentWriteOff::class);
    }

    public function updateDocumentComing(int $id = null)
    {
        $title = 'Новый документ поступление';
        $model = new DocumentComing();
        $keyDocument = DocumentBase::keyDocument(DocumentComing::class);
        /* @var $model DocumentComing */
        if ($id) {
            $model = DocumentComing::filter()
                ->where(DocumentComing::table('id'), $id)
                ->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ поступление №' . $model->id;
        }
        $this->data = [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new DocumentComing)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'keyDocument' => $keyDocument,
        ];
        if ($model->status === Status::STATUS_POST) {
            return $this->viewDocument();
        }
        return view('backend.document.document_update', $this->data);
    }

    public function updateDocumentWriteOff(int $id = null)
    {
        $title = 'Новый документ списание';
        $model = new DocumentWriteOff();
        $keyDocument = DocumentBase::keyDocument(DocumentWriteOff::class);
        /* @var $model DocumentWriteOff */
        if ($id) {
            $model = DocumentWriteOff::filter()
                ->where(DocumentWriteOff::table('id'), $id)
                ->first();
            if (!$model) {
                abort(404);
            }
            $title = 'Документ списание №' . $model->id;
        }
        $this->data = [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new DocumentWriteOff)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'keyDocument' => $keyDocument,
        ];
        if ($model->status === Status::STATUS_POST) {
            return $this->viewDocument();
        }
        return view('backend.document.document_update', $this->data);
    }

    public function deleteDocument(int $id = null)
    {
        /* @var $model CatalogDocument */
        if ($id) {
            $model = CatalogDocument::filter()
                ->where(CatalogDocument::table('id'), $id)
                ->first();
            if (!$model) {
                abort(404);
            }
            if ($model->status === CatalogDocument::STATUS_POST) {
                return $this->viewDocument($model);
            }
            $title = 'Документ №' . $model->id;
        }
        return view('backend.document.document_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
        ]);
    }

    public function viewDocument()
    {
        return view('backend.document.document_view', $this->data);
    }
}
