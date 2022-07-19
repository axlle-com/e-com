<?php

namespace App\Common\Components\Delivery;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use Illuminate\Support\Facades\Http;

class Cdek
{
    use Errors;

    private string $path = 'https://kladr-api.ru/api.php';
    private ?array $body;
    private ?int $time;

    public function __construct(array $body = null, ?string $url = null, int $time = 30)
    {
        if (!empty($url)) {
            $this->path .= $url;
        }
        $this->body = $body ?? [];
        $this->time = $time;
    }

    public function get(): ?array
    {
        $response = null;
        try {
            $response = Http::timeout($this->time)->get($this->path, $this->body);
        } catch (\Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($response) && $response->successful()) {
            return $response->json();
        }
        return null;
    }

    public function post(): ?array
    {
        $response = null;
        try {
            $response = Http::timeout($this->time)->post($this->path, $this->body);
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

}
