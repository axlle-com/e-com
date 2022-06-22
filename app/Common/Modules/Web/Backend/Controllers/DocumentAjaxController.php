<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DocumentAjaxController extends WebController
{
    private string $title;
    private array $post;
    private mixed $models;
    private mixed $model;
    private string $type;

    ##### index #####
    private function getIndexData($class): Response|JsonResponse
    {
        $view = view('backend.ajax.document', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin('index'),
            'models' => $this->models,
            'post' => $this->post,
            'isAjax' => true,
            'keyDocument' => DocumentBase::keyDocument($class),
        ])->render();
        $data = ['view' => _clear_soft_data($view)];
        return $this->setData($data)->response();
    }

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

    public function writeOff(): Response|JsonResponse
    {
        $this->models = DocumentWriteOff::filterAll($this->post);
        return $this->getIndexData(DocumentWriteOff::class);
    }

    ##### save #####
    private function getSaveData($class): Response|JsonResponse
    {
        $view = view('backend.document.document_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin(),
            'title' => 'Документ №' . $this->model->id,
            'model' => $this->model,
            'post' => $this->request(),
            'keyDocument' => DocumentBase::keyDocument($class),
        ])->renderSections()['content'];
        $data = [
            'view' => _clear_soft_data($view),
            'url' => '/admin/catalog/document/' . $this->type . '-update/' . $this->model->id,
        ];
        return $this->setData($data)->response();
    }

    public function saveDocumentRoute(): Response|JsonResponse
    {
        if ($this->post = $this->validation(['type' => 'required|string'])) {
            if ($this->post = $this->validation(DocumentBase::rules())) {
                $this->type = $this->post['type'];
                $method = 'save' . Str::studly($this->type);
                if (method_exists($this, $method)) {
                    return $this->{$method}();
                }
                return $this->badRequest()->error();
            }
        }
        return $this->error();
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

    public function saveWriteOff(): Response|JsonResponse
    {
        $this->model = DocumentWriteOff::createOrUpdate($this->post);
        if ($errors = $this->model->getErrors()) {
            $this->setErrors($errors);
            return $this->error($this::ERROR_BAD_REQUEST);
        }
        return $this->getSaveData(DocumentWriteOff::class);

    }

    ##### posting #####
    private function getPostingData($class): Response|JsonResponse
    {
        $view = view('backend.document.document_view', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new $class)->breadcrumbAdmin(),
            'title' => 'Документ №' . $this->model->id,
            'model' => $this->model,
            'post' => $this->request(),
            'keyDocument' => DocumentBase::keyDocument($class),
        ])->renderSections()['content'];
        $data = [
            'view' => _clear_soft_data($view),
            'url' => '/admin/catalog/document/' . $this->type . '-update/' . $this->model->id,
        ];
        return $this->setData($data)->response();
    }

    public function postingDocumentRoute(): Response|JsonResponse
    {
        if ($this->post = $this->validation(['type' => 'required|string'])) {
            if ($this->post = $this->validation(CatalogDocument::rules())) {
                $this->type = $this->post['type'];
                $method = 'posting' . Str::studly($this->type);
                if (method_exists($this, $method)) {
                    return $this->{$method}();
                }
                return $this->badRequest()->error();
            }
        }
        return $this->error();
    }

    public function postingComing(): Response|JsonResponse
    {
        if ($this->post = $this->validation(DocumentBase::rules('posting'))) {
            $this->model = DocumentComing::createOrUpdate($this->post)->posting();
            if ($errors = $this->model->getErrors()) {
                $this->setErrors($errors);
                return $this->error($this::ERROR_BAD_REQUEST);
            }
            return $this->getPostingData(DocumentComing::class);
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

    public function loadDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|integer'])) {
            $model = CatalogDocument::filter()
                ->where(CatalogDocument::table('id'), $post['id'])
                ->first();
            $view = view('backend.ajax.document_content_load', [
                'model' => $model,
            ])->render();
            $target = $model->subject_title ?? 'Документ';
            $target .= ' №';
            $target .= $model->id ?? 0;
            $target .= ' от ';
            $target .= (isset($model['created_at']) ? _unix_to_string_moscow($model['created_at']) : '');
            $data = [
                'view' => _clear_soft_data($view),
                'target' => $target,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function deleteDocumentContent(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|numeric', 'model' => 'required|string'])) {
            $class = BaseModel::className($post['model']);
            $model = $class::deleteContent($post['id']);
            if (!$model) {
                return $this->badRequest()->error();
            }
            return $this->setMessage('Позиция удалена')->response();
        }
        return $this->error();
    }

    public function deleteDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|numeric'])) {
            if (CatalogDocument::deleteById($post['id'])) {
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
}
