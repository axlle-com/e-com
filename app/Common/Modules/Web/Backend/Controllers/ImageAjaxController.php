<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\Gallery\GalleryImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ImageAjaxController extends BackendController
{
    public function deleteImage(): Response|JsonResponse
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
