<?php

namespace App\Common\Components\Delivery;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Cdek
{
    use Errors;

    private string $token;
    private string $path;
    private string $url = '';
    private ?array $body;
    private ?int $time;
    private ?array $objects = [];
    private ?array $objectsCdek = [];

    public function __construct(array $body = null, ?string $url = null, int $time = 30)
    {
        $this->path = config('cdek.url');
        if (!empty($url)) {
            $this->url = $this->path . trim($url, '/');
        }
        $this->body = $body ?? [];
        $this->time = $time;
        if (Cache::has('_cdek_authorization')) {
            $this->token = Cache::get('_cdek_authorization');
        } else {
            for ($i = 0; $i < 5; $i++) {
                $this->authorization();
                if (!$this->getErrors()) {
                    break;
                }
            }
        }
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
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            $token = $response->json();
            $this->token = $token['access_token'];
            Cache::put('_cdek_authorization', $token['access_token'], $seconds = $token['expires_in'] - 10);
        }
        $this->setErrors(_Errors::error(['Не удалось получить токен'], $this));
    }

    public function get(array $body = null, string $url = null): ?array
    {
        $response = null;
        try {
            $response = Http::withToken($this->token)->timeout($this->time)->get($url ?? $this->url, $body ?? $this->body);
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            return $response->json();
        }
        return null;
    }

    public function post(array $body = null, string $url = null): ?array
    {
        $response = null;
        try {
            $response = Http::withToken($this->token)->timeout($this->time)->post($this->url, $this->body);
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            return $response->json();
        }
        return null;
    }

    public function city(): ?array
    {
        $this->body['contentType'] = 'city';
        $this->body['withParent'] = 1;
        $this->body['limit'] = 30;
        if (($data = $this->get()) && !empty($data['result'])) {
            unset($data['result'][0]);
            $city = [];
            foreach ($data['result'] as $result) {
                $name = $result['name'];
                $parent = $result['parents'][0] ?? null;
                if (!empty($parent)) {
                    $name .= ' ' . ($parent['name'] ?? null);
                    $name .= ' ' . ($parent['type'] ?? null);
                    $name = trim($name);
                }
                $city[] = [
                    'id' => $result['id'],
                    'text' => $name,
                ];
            }
            return $city;
        }
        return null;
    }

    public static function objectsById($city_code = null): self
    {
        $self = new Cdek(['city_code' => $city_code], 'v2/deliverypoints');
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
                    'options' => [
                        'hideIconOnBalloonOpen' => false
                    ],
                ],
            ];
        }
        return $self;
    }

    public function getObjectsCdek(): ?array
    {
        return $this->objectsCdek;
    }

    public function getObjectsJson(): ?array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => $this->objects,
        ];
    }

    public function setObjects(?array $objects): Cdek
    {
        $this->objects = $objects;
        return $this;
    }


}
