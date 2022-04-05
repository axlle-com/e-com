<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\GalleryImage;
use Illuminate\Http\JsonResponse;

class ImageAjaxController extends WebController
{
    public function deleteImage(): JsonResponse
    {
        if ($post = $this->validation(GalleryImage::rules('delete'))) {

            return $this->setStatus(1)->response();
        }
        return $this->error();
    }
}
