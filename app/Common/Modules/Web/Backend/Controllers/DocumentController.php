<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogDocument;

class DocumentController extends WebController
{
    public function indexDocument()
    {
        $post = $this->request();
        $title = 'Список документов';
        $models = CatalogDocument::filterAll($post);
        return view('backend.catalog.document', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updateDocument(int $id = null)
    {
        $title = 'Новый документ';
        $model = new CatalogDocument();
        /* @var $model CatalogDocument */
        if ($id) {
            $model = CatalogDocument::filter()
                ->where(CatalogDocument::table('id'), $id)
                ->first();
            if (!$model) {
                abort(404);
            }
            if($model->status === CatalogDocument::STATUS_POST){
                return $this->viewDocument($model);
            }
            $title = 'Документ №' . $model->id;
        }
        return view('backend.catalog.document_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
        ]);
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
            if($model->status === CatalogDocument::STATUS_POST){
                return $this->viewDocument($model);
            }
            $title = 'Документ №' . $model->id;
        }
        return view('backend.catalog.document_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
        ]);
    }

    public function viewDocument(CatalogDocument $model)
    {
        $title = 'Документ №' . $model->id;
        return view('backend.catalog.document_view', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new CatalogDocument)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
        ]);
    }
}
