<?php

namespace Web\Backend\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\Product\CatalogProductWidgetsContent;

class WidgetAjaxController extends WebController
{
    public function deleteWidget(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogProductWidgetsContent::rules('delete'))) {
            $model = CatalogProductWidgetsContent::deleteAnyContent($post);
            if ($model->getErrors()) {
                return $this->setErrors($model->getErrors())->badRequest()->error();
            }
            return $this->response();
        }
        return $this->error();
    }
}
