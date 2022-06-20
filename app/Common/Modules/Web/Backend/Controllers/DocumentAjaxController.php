<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\CatalogDocumentContent;
use App\Common\Models\Catalog\Product\CatalogProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DocumentAjaxController extends WebController
{
    public function indexDocument()
    {
        $post = $this->body();
        $models = CatalogDocument::filterAll($post);
        $view = view('backend.ajax.document', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'models' => $models,
            'post' => $post,
            'isAjax' => true,
        ])->render();
        $data = ['view' => _clear_soft_data($view)];
        return $this->setData($data)->response();
    }

    public function getProduct(): Response|JsonResponse
    {
        if ($post = $this->validation(['q' => 'required|string'])) {
            $models = CatalogProduct::search($post['q']);
            return $this->setData($models)->response();
        }
        return $this->error();
    }

    public function saveDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogDocument::rules())) {
            $post['user_id'] = $this->getUser()->id;
            $post['ip'] = $this->getUser()->ip;
            $model = CatalogDocument::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->error($this::ERROR_BAD_REQUEST);
            }
            $view = view('backend.document.document_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin(),
                'title' => 'Документ №' . $model->id,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => _clear_soft_data($view),
                'url' => '/admin/catalog/document/update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function postingDocument(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogDocument::rules('posting'))) {
            $post['user_id'] = $this->getUser()->id;
            $post['ip'] = $this->getUser()->ip;
            $model = CatalogDocument::createOrUpdate($post)->posting();
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->error($this::ERROR_BAD_REQUEST);
            }
            $view = view('backend.document.document_view', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin(),
                'title' => 'Документ №' . $model->id,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => _clear_soft_data($view),
                'url' => '/admin/catalog/document/update/' . $model->id,
            ];
            return $this->setData($data)->response();
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
        if ($post = $this->validation(['id' => 'required|numeric'])) {
            $model = CatalogDocumentContent::deleteContent($post['id']);
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
}
