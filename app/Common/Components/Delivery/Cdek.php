<?php

namespace App\Common\Components\Delivery;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use App\Common\Models\User\UserWeb;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Cdek
{
    use Errors;

    public const STORAGE_TARIFFS_S_S = 136;
    public const STORAGE_TARIFFS_S_P = 368;
    public const COURIER_TARIFFS_S_D = 137;
    public const STORAGE_DELIVERY_TARIFFS = [self::STORAGE_TARIFFS_S_S, self::STORAGE_TARIFFS_S_P];
    public const COURIER_DELIVERY_TARIFFS = [self::COURIER_TARIFFS_S_D];

    public const TARIFFS = [
        self::STORAGE_TARIFFS_S_S => 'Посылка склад-склад',
        self::STORAGE_TARIFFS_S_P => 'Посылка склад-постамат',
        self::COURIER_TARIFFS_S_D => 'Посылка склад-дверь',
    ];

    private string $token = '';
    private string $path;
    private string $url = '';
    private int $cityFrom;
    private ?array $body;
    private ?int $time;
    private ?array $objects = [];
    private ?array $objectsCdek = [];
    private ?array $pvz = [];
    private ?array $response = [];
    private array $tariffs;
    private array $courierDeliveryMode = [3];
    private array $storageDeliveryMode = [7, 4];
    private array $defaultLocation = [45.040199, 38.976113];
    private int $defaultCityCode = 435;
    private string $defaultFias = '7dfa745e-aa19-4688-b121-b655c11e482f';

    public function __construct(array $body = null, ?string $url = null, bool $auth = true, int $time = 30)
    {
        $this->path = config('cdek.url');
        $this->setBody($body)->setUrl($url);
        $this->time = $time;
        $this->tariffs = array_merge(self::COURIER_DELIVERY_TARIFFS, self::STORAGE_DELIVERY_TARIFFS);
        if ($auth) {
            if (Cache::has('_cdek_authorization')) {
                $this->token = Cache::get('_cdek_authorization');
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $this->authorization();
                    if (!$this->getErrors()) {
                        break;
                    }
                    sleep(1);
                }
            }
        }
    }

    public static function objectsById($city_code = null): self
    {
        $self = new Cdek($city_code ? ['fias_guid' => $city_code] : null, 'v2/deliverypoints');
        $cdek = $self->get();
        $array = [];
        foreach ($cdek as $value) {
            $self->objectsCdek[$value['code']] = $value;
            $self->objects[] = [
                'type' => 'Feature',
                'id' => $value['code'],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$value['location']['latitude'], $value['location']['longitude']],
                    'properties' => [
                        'balloonContent' => 'false',
                        'hintContent' => 'false',
                    ],
                    'options' => ['hideIconOnBalloonOpen' => false,],
                ],
            ];
        }
        return $self;
    }

    public static function calculate(array $data): array
    {
        $basket = CatalogBasket::getBasket(UserWeb::auth()->id ?? null);
        $ids = array_keys($basket['items']);
        $data['packages'] = CatalogProduct::getPropertyForDelivery($ids);
        $self = new self($data, '/v2/calculator/tarifflist');
        $self->post();
        $arr = [];
        foreach ($self->response['tariff_codes'] ?? [] as $value) {
            $tariffCode = (int)$value['tariff_code'];
            $deliveryMode = (int)$value['delivery_mode'];
            if (!in_array($tariffCode, $self->tariffs, true)) {
                continue;
            }
            if (in_array($deliveryMode, $self->storageDeliveryMode, true)) {
                $arr['storage'][0] = $value;
            }
            if (in_array($deliveryMode, $self->courierDeliveryMode, true)) {
                $arr['courier'][0] = $value;
            }
        }
        session(['_cdek_tariffs' => $arr]);
        return $arr;
    }

    public static function calculateDefault(): array
    {
        $self = new self();
        $fias = '';
        if (!$ip = DaDataClient::ip()) {
            $ip = DaDataClient::$default;
        }
        $pvz = self::getPvz();
        $cityCode = $pvz['cities_has_uuid'][$ip['city_fias_id'] ?? ''] ?? null;
        $fias = $ip['city_fias_id'];
        if (!$cityCode) {
            $cityCode = $pvz['cities_has_uuid'][$ip['fias_id']] ?? null;
            $fias = $ip['city_fias_id'];
        }
        if (!$cityCode) {
            $cityCode = $pvz['cities_has_uuid'][$ip['region_fias_id']] ?? null;
            $fias = $ip['city_fias_id'];
        }
        $location = [$ip['location'][0], $ip['location'][1]];
        if (empty($cityCode)) {
            $cityCode = $self->defaultCityCode;
            $fias = $self->defaultFias;
        }
        session(['_delivery' => ['fias' => $fias]]);
        if (empty($location)) {
            $location = $self->defaultLocation;
        }
        $data = ['to_location' => ['code' => $cityCode]];
        $basket = CatalogBasket::getBasket(UserWeb::auth()->id ?? null);
        $ids = array_keys($basket['items']);
        $data['packages'] = CatalogProduct::getPropertyForDelivery($ids);
        $self->setBody($data)->setUrl('/v2/calculator/tarifflist')->post();
        $arr = [];
        $arr['city_code'] = $cityCode;
        $arr['location'] = $location;
        foreach ($self->response['tariff_codes'] ?? [] as $value) {
            $tariffCode = (int)$value['tariff_code'];
            $deliveryMode = (int)$value['delivery_mode'];
            if (!in_array($tariffCode, $self->tariffs, true)) {
                continue;
            }
            if (in_array($deliveryMode, $self->storageDeliveryMode, true)) {
                $arr['calculate']['storage'][0] = $value;
            }
            if (in_array($deliveryMode, $self->courierDeliveryMode, true)) {
                $arr['calculate']['courier'][0] = $value;
            }
        }
        session(['_cdek_tariffs' => $arr['calculate'] ?? []]);
        return array_merge($arr, $pvz ?? []);
    }

    public static function getPvz(): array
    {
        $self = new self(auth: false);
        if (Cache::has('_cdek_pvz')) {
            return Cache::get('_cdek_pvz');
        }
        for ($i = 0; $i < 5; $i++) {
            $self->setPvz();
            if (!$self->getErrors()) {
                Cache::put('_cdek_pvz', $self->pvz, 60 * 60 * 24 * 10);
                return $self->pvz;
            }
            sleep(1);
        }
        return $self->pvz;
    }

    public static function coordinates(int $code): array
    {
        $self = (new self(['code' => $code], '/v2/location/cities'))->get();
        $response = $self->getResponse();
        if (!empty($response[0])) {
            session(['_delivery' => ['fias' => $response[0]['fias_guid']]]);
            return $response[0];
        }
        return [];
    }

    public static function pvz(): array
    {
        $self = (new self([], '/v2/deliverypoints'))->get();
        $response = $self->getResponse();
        $self->setPvz();
        if (!empty($response[0])) {
            session(['_delivery' => ['fias' => $response[0]['fias_guid']]]);
            return $response[0];
        }
        return [];
    }

    public function setUrl(?string $url = null): self
    {
        if (!empty($url)) {
            $this->url = $this->path . trim($url, '/');
        }
        return $this;
    }

    public function setBody(?array $body = null): self
    {
        $this->body = $body ?? [];
        $this->body['from_location']['code'] = $this->defaultCityCode;
        return $this;
    }

    public function get(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->token)
                ->timeout($this->time)
                ->get($url ?? $this->url, $body ?? $this->body);
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        $this->debug['response'] = $response?->json();
        if (isset($response) && $response->successful()) {
            $this->response = $response->json();
        }
        return $this;
    }

    public function post(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->token)
                ->timeout($this->time)
                ->post($url ?? $this->url, $body ?? $this->body);
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        $this->debug['response'] = $response?->json();
        if (isset($response) && $response->successful()) {
            $this->response = $response->json();
        }
        return $this;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    private function authorization(): void
    {
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => config('cdek.account'),
            'client_secret' => config('cdek.password'),
        ];
        $url = $this->path . 'v2/oauth/token?parameters';
        $response = null;
        try {
            $response = Http::timeout($this->time)->asForm()->post($url, $data);
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            $token = $response->json();
            $this->token = $token['access_token'];
            Cache::put('_cdek_authorization', $token['access_token'], $token['expires_in'] - 10);
        } else {
            $this->setDebug($response)->setErrors(_Errors::error(['Не удалось получить токен'], $this));
        }
    }

    private function setPvz(): void
    {
        if (!function_exists('simplexml_load_string')) { //!function_exists('simplexml_load_string')
            $this->setPvzApi();
        } else {
            $this->setPvzXml();
        }
    }

    private function setPvzApi(): void
    {
        $self = (new self(null, '/v2/deliverypoints'))->get();
        $response = $self->getResponse();
        if ($response) {
            $list = [];
            $json = [];
            $cityList = [];
            $cityListHasUuid = [];
            foreach ($response as $key => $val) {
                $cityCode = (string)$val['location']['city_code'];
                $city = (string)$val['location']['city'];
                $code = (string)$val['code'];
                if (str_contains($city, '(')) {
                    $city = trim(substr($city, 0, strpos($city, '(')));
                }
                if (str_contains($city, ',')) {
                    $city = trim(substr($city, 0, strpos($city, ',')));
                }
                $cityList[$cityCode] = $city . '  ' . $val['location']['region'];
                if (!empty($val['location']['fias_guid'])) {
                    $cityListHasUuid[(string)$val['location']['fias_guid']] = $cityCode;
                }
                $json[$cityCode]['type'] = 'FeatureCollection';
                $json[$cityCode]['features'][] = [
                    'type' => 'Feature',
                    'id' => $code,
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(string)$val['location']['latitude'], (string)$val['location']['longitude']],
                        'properties' => [
                            'balloonContent' => 'false',
                            'hintContent' => 'false',
                        ],
                        'options' => ['hideIconOnBalloonOpen' => false,],
                    ],
                    'select' => [
                        'id' => $code,
                        'title' => $city . ' ' . $val['location']['address'],
                    ],
                ];
                $list[$code] = [
                    'city' => $city,
                    'city_code' => $cityCode,
                    'address' => (string)$val['location']['address'],
                    'address_comment' => (string)($val['address_comment'] ?? ''),
                    'name' => (string)$val['name'],
                    'work_time' => (string)$val['work_time'],
                    'phone' => (string)($val['phones'][0]['number'] ?? ''),
                    'note' => (string)($val['note'] ?? ''),
                    'coordinates_x' => (string)$val['location']['longitude'],
                    'coordinates_y' => (string)$val['location']['latitude'],
                    'dressing' => ((string)$val['is_dressing_room'] === '1'),
                    'cash' => ((string)$val['have_cashless'] === '1'),
                    'postamat' => (strtolower($val['type']) === 'POSTAMAT'),
                    'station' => (string)($val['nearest_station'] ?? ''),
                    'site' => (string)($val['site'] ?? ''),
                    'metro' => (string)($val['nearest_metro_station'] ?? ''),
                ];
                $list[$code]['weight_min'] = (float)($val['weight_min'] ?? 0);
                $list[$code]['weight_max'] = (float)($val['weight_max'] ?? 0);
                $images = [];
                foreach ($val['office_image_list'] ?? [] as $img) {
                    if (!str_contains($tmpUrl = (string)$img['url'], 'http')) {
                        continue;
                    }
                    $images[] = $tmpUrl;
                }
                $list[$code]['images'] = $images;
            }
            $this->pvz = [
                'cities_list' => $cityList,
                'cities_has_uuid' => $cityListHasUuid,
                'objects_list' => $list,
                'objects_json' => $json,
            ];
        } else {
            $this->setErrors(_Errors::error('Не удалось получить пункты выдачи.', $this));
        }
    }

    private function setPvzXml(): void
    {
        $curlOptions = [
            CURLOPT_URL => 'https://integration.cdek.ru/pvzlist/v1/xml?type=ALL',
            CURLOPT_RETURNTRANSFER => true,
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $list = [];
        $json = [];
        $cityList = [];
        $cityListHasUuid = [];
        if ($result && $code === 200) {
            $xml = simplexml_load_string($result);
            foreach ($xml as $key => $val) {
                $cityCode = (string)$val['CityCode'];
                $city = (string)$val['City'];
                $code = (string)$val['Code'];
                if (str_contains($city, '(')) {
                    $city = trim(substr($city, 0, strpos($city, '(')));
                }
                if (str_contains($city, ',')) {
                    $city = trim(substr($city, 0, strpos($city, ',')));
                }
                $cityList[$cityCode] = $city . '  ' . $val['RegionName'];
                if (!empty($val['FiasGuid'])) {
                    $cityListHasUuid[(string)$val['FiasGuid']] = $cityCode;
                }
                $json[$cityCode]['type'] = 'FeatureCollection';
                $json[$cityCode]['features'][] = [
                    'type' => 'Feature',
                    'id' => $code,
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(string)$val['coordY'], (string)$val['coordX']],
                        'properties' => [
                            'balloonContent' => 'false',
                            'hintContent' => 'false',
                        ],
                        'options' => ['hideIconOnBalloonOpen' => false,],
                    ],
                    'select' => [
                        'id' => $code,
                        'title' => $city . ' ' . $val['Address'],
                    ],
                ];
                $list[$code] = [
                    'city' => $city,
                    'city_code' => (string)$val['CityCode'],
                    'address' => (string)$val['Address'],
                    'address_comment' => (string)$val['AddressComment'],
                    'name' => (string)$val['Name'],
                    'work_time' => (string)$val['WorkTime'],
                    'phone' => (string)$val['Phone'],
                    'note' => (string)$val['Note'],
                    'coordinates_x' => (string)$val['coordX'],
                    'coordinates_y' => (string)$val['coordY'],
                    'dressing' => ((string)$val['IsDressingRoom'] === 'true'),
                    'cash' => ((string)$val['HaveCashless'] === 'true'),
                    'postamat' => (strtolower($val['Type']) === 'postamat'),
                    'station' => (string)$val['NearestStation'],
                    'site' => (string)$val['Site'],
                    'metro' => (string)$val['MetroStation'],
                ];
                if ($val->WeightLimit) {
                    $list[$code]['weight_min'] = (float)$val->WeightLimit['WeightMin'];
                    $list[$code]['weight_max'] = (float)$val->WeightLimit['WeightMax'];
                }
                $images = [];
                foreach ($val->OfficeImage as $img) {
                    if (!str_contains($tmpUrl = (string)$img['url'], 'http')) {
                        continue;
                    }
                    $images[] = $tmpUrl;
                }
                $list[$code]['images'] = $images;
            }
            $this->pvz = [
                'cities_list' => $cityList,
                'cities_has_uuid' => $cityListHasUuid,
                'objects_list' => $list,
                'objects_json' => $json,
            ];
        } else {
            $this->setErrors(_Errors::error('Не удалось получить пункты выдачи.', $this));
        }
    }
}
