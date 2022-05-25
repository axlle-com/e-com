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
                $mess = implode('|', $errors);
                return $this->error($this::ERROR_BAD_REQUEST, $mess);
            }
            $view = view('backend.catalog.document_update', [
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
        if ($post = $this->validation(CatalogDocument::rules())) {
            $post['user_id'] = $this->getUser()->id;
            $post['ip'] = $this->getUser()->ip;
            $model = CatalogDocument::createOrUpdate($post)->posting();
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                $mess = implode('|', $errors);
                return $this->error($this::ERROR_BAD_REQUEST, $mess);
            }
            $view = view('backend.catalog.document_view', [
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
