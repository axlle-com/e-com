<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Gallery\GalleryImage;
use Illuminate\Http\JsonResponse;

class ImageAjaxController extends WebController
{
    public function deleteImage(): JsonResponse
    {
        if ($post = $this->validation(GalleryImage::rules('delete'))) {
            $model = GalleryImage::deleteAnyImage($post);
            if ($model->getErrors()) {
                return $this->setErrors($model->getErrors())->badRequest()->error();
            }
            return $this->response();
        }
        return $this->error();
    }
}
