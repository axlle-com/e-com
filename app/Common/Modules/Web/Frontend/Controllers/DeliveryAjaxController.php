<?php

namespace Web\Frontend\Controllers;

use App\Common\Components\Delivery\Cdek;
use App\Common\Components\Delivery\DaDataClient;
use App\Common\Http\Controllers\WebController;
use App\Common\Models\Errors\_Errors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeliveryAjaxController extends WebController
{
    public function city(): Response|JsonResponse
    {
        if ($post = $this->validation(['term' => 'required|string'])) {
            $data = ['query' => $post['term']];
            //            $models = DaDataClient::address($post['term']);
            _dd_((new Cdek([
                'size' => 6000,
                'country_codes' => 'RU',
            ], 'v2/location/cities'))->get());
            return $this->setData('$models')->response();
        }
        return $this->error();
    }

    public function goods(): Response|JsonResponse
    {
        $models = [
            'goods' => [
                [
                    'length' => 10,
                    'width' => 10,
                    'height' => 10,
                    'weight' => 100,
                ],
            ],
        ];
        return $this->setData($models)->response();
    }

    public function getObject(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|string'])) {
            $start = microtime(true);
            $data = [
                'calculate' => Cdek::calculate(['to_location' => ['code' => $post['id']]]),
                'coordinates' => Cdek::coordinates($post['id']),
            ];
            if (!$data['calculate']) {
                $this->setErrors(_Errors::error('Не удалось рассчитать стоимость доставки.', $this));
            }
            if (!$data['coordinates']) {
                $this->setErrors(_Errors::error('Не удалось загрузить выбранному региону', $this));
            }
            $data['time'] = microtime(true) - $start;
            if ($this->getErrors()) {
                return $this->error();
            }
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function getAddressCourier(): Response|JsonResponse
    {
        if ($post = $this->validation(['q' => 'required|string'])) {
            return $this->setData(DaDataClient::addressForSelect($post['q']))->response();
        }
        return $this->error();
    }

    public function getDeliveryInfo(): Response|JsonResponse
    {
        $data = Cdek::calculateDefault();
        return $this->setData($data)->setGzip(false)->response();
    }
}

