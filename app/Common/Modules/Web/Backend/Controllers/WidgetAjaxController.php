<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\Catalog\Product\CatalogProductWidgetsContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WidgetAjaxController extends BackendController
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
