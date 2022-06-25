<?php

namespace App\Common\Components\Bank;

use App\Common\Models\Main\Errors;

class Alfa
{
    use Errors;

    public const DEFAULT_MESSAGE_ERROR = ['pay' => 'Произошла ошибка при отправке'];

    private string $url;
    private string $username;
    private string $password;
    private string $method;
    private array $body;
    private array $data;

    public function __construct()
    {
        if (env('APP_IS_TEST', false)) {
            $this->url = env('ALFA_TEST_URL', '#');
            $this->body = [
                'userName' => env('ALFA_TEST_USERNAME', 'username'),
                'password' => env('ALFA_TEST_PASSWORD', 'password'),
                'returnUrl' => env('APP_URL') . '/user/order-pay',
            ];
        } else {
            $this->url = env('ALFA_URL', '#');
            $this->body = [
                'userName' => env('ALFA_USERNAME', 'username'),
                'password' => env('ALFA_PASSWORD', 'password'),
                'returnUrl' => env('APP_URL') . '/user/order-pay',
            ];
        }
    }

    public function setBody(array $body = []): static
    {
        $this->body = array_merge_recursive($this->body, $body);
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
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->url . $this->method,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($this->body)
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
        } catch (\Exception $exception) {
            $this->setException($exception);
        }
        if ($response['errorCode'] ?? null) {
            return $this->setErrors($response);
        }
        return $this->setData($response ?? []);
    }

    public function setData($data): static
    {
        $this->data = $data ?? [];
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
