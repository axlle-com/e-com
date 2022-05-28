<?php

namespace App\Common\Components\Bank;

use App\Common\Models\Main\Errors;

class Alfa
{
    use Errors;

    public const GATEWAY_URL = 'https://web.rbsuat.com/';

    private string $username;
    private string $password;
    private string $method;
    private array $body;
    private array $data;

    public function __construct()
    {
        $this->body = [
            'userName' => env('ALFA_USERNAME', 'username'),
            'password' => env('ALFA_PASSWORD', 'password'),
            'returnUrl' => env('APP_URL') . '/user/profile/order',
        ];
    }

    public function setBody(array $body = []): static
    {
        $amount = $body['amount'] ?? null;
        $orderNumber = $body['orderNumber'] ?? null;
        if (isset($amount, $orderNumber)) {
            $this->body['orderNumber'] = $orderNumber;
            $this->body['amount'] = $amount;
        } else {
            $this->setErrors(['Заполнены не все обязательные поля']);
        }
        return $this;
    }

    public function setMethod(string $method): static
    {
        $this->method = trim($method, '/');
        return $this;
    }

    public function send(): static
    {
        if ($this->getErrors()) {
            return $this;
        }
        if (empty($this->method)) {
            return $this->setErrors(['Метод не может быть пустым']);
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => self::GATEWAY_URL . $this->method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($this->body)
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        if ($response['errorCode'] ?? null) {
            return $this->setErrors($response);
        }
        return $this->setData($response);
    }

    public function setData($data): static
    {
        $this->data = $data;
        return $this;
    }
}
