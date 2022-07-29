<?php

namespace App\Common\Components\Delivery;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use Illuminate\Support\Facades\Http;

class DaDataClient
{
    use Errors;

    public const BASE_URL = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/';

    private string $token;
    private string $secret;
    private string $path;
    private string $url = '';
    private ?array $body;
    private ?int $time;
    private array $response = [];

    public function __construct(array $body = null, string $url = '', int $time = 30)
    {
        $this->body = $body ?? [];
        $this->time = $time;
        $this->token = config('dadata.token');
        $this->secret = config('dadata.secret');
        $this->path = self::BASE_URL . trim($url, '/');
    }

    public static function address($query): array
    {
        $self = new self(['query' => $query], '/suggest/address');
        $self->post();
        $array = [];
        foreach ($self->response['suggestions'] ?? [] as $value) {
            $array['select'][] = [
                'id' => $value['data']['fias_id'],
                'text' => $value['value'],
            ];
            $array['info'][$value['data']['fias_id']] = $value['data'];
        }
        return $array;
    }

    public function post(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->token, 'Token')->timeout($this->time)->post($url ?? $this->path, $body ?? $this->body);
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            $this->response = $response->json();
        }
        return $this;
    }

    public static function addressForSelect($query): array
    {
        $data = [
            'query' => $query,
            'locations' => [
                ['fias_id' => session('_delivery', [])['fias'] ?? null]
            ]
        ];
        $self = new self($data, '/suggest/address');
        $self->post();
        $array = [];
        foreach ($self->response['suggestions'] ?? [] as $value) {
            $array[] = [
                'id' => $value['value'],
                'text' => $value['value'],
                'location' => [$value['data']['geo_lat'] ?? '', $value['data']['geo_lon'] ?? ''],
            ];
        }
        return $array;
    }

    public static function ip(): ?array
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? '46.226.227.20' : $_SERVER['REMOTE_ADDR'];
            $self = new self(['ip' => $ip], 'iplocate/address');
            if (($res = $self->post()->getResponse()) && ($data = $res['location']['data'] ?? null)) {
                return [
                    'location' => [$data['geo_lat'], $data['geo_lon']],
                    'city_fias_id' => $data['city_fias_id'],
                    'fias_id' => $data['fias_id'],
                    'region_fias_id' => $data['region_fias_id'],
                ];
            }
        }
        return null;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    public function setResponse(?array $response): DaDataClient
    {
        $this->response = $response;
        return $this;
    }

    public function get(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->token, 'Token')->timeout($this->time)->get($url ?? $this->path, $body ?? $this->body);
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            $this->response = $response->json();
        }
        return $this;
    }

    public function findById($query, $count = 1, $kwargs = [])
    {
        $url = static::BASE_URL . 'findById/party';
        $data = ['query' => $query, 'count' => $count];
        $data = array_merge($data, $kwargs);
        $response = $this->post($url, $data);
        return $this->objectToArray($response)['suggestions'];
    }

    public function findByIdBank($query)
    {
        $url = static::BASE_URL . 'findById/bank';
        $data = ['query' => $query];
        $response = $this->post($url, $data);
        $response = $this->objectToArray($response);
        return $response['suggestions'][0] ?? [];
    }

    public function getParseName($query)
    {
        $url = 'https://cleaner.dadata.ru/api/v1/clean/name';
        $data = [$query];
        $response = $this->post($url, $data);
        return $this->objectToArray($response);
    }
}
