<?php

namespace Rest\Backend\v1\Controllers;

use App\Common\Http\Controllers\RestController;
use App\Common\Models\Errors\Logger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WebHookController extends RestController
{
    public function telegram(): Response|JsonResponse
    {
        if ($post = $this->validation()) {
            Logger::model()->group('history')->debug(__FUNCTION__, $post);
            return $this->response();
        }
        return $this->error();
    }
}
