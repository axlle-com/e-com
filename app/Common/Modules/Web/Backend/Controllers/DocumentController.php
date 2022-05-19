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
            $model = CatalogDocument::query()
                ->with(['contents'])
                ->where('id', $id)
                ->first();
            if (!$model) {
                abort(404);
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
}
