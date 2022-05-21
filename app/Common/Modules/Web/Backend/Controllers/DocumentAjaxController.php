<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogDocument;
use App\Common\Models\Catalog\CatalogProduct;
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
                return $this->badRequest()->error();
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

    public function deleteDocument(int $id = null): JsonResponse
    {
        if (CatalogDocument::deleteById($id)) {
            $this->setMessage('Документ успешно удален!');
            $this->setStatus(1);
        } else {
            $this->setMessage('Произошла ошибка, попробуйте позднее!');
            $this->setStatus(0);
        }
        return $this->response();
    }
}
