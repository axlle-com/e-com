<?php

namespace App\Common\Components\Bank;

use Exception;
use App\Common\Models\Errors\Errors;
use App\Common\Models\Errors\_Errors;

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
        $this->url = config('alfa.url');
        $this->body = [
            'userName' => config('alfa.username'),
            'password' => config('alfa.password'),
            'returnUrl' => config('app.url') . '/user/order-pay',
        ];
    }

    public static function payOrder(int $amount, string $number): static
    {
        return (new self())
            ->setMethod('/register.do')
            ->setReturnUrl('/user/order-pay')
            ->setBody(['amount' => $amount * 100, 'orderNumber' => $number])
            ->send();
    }

    public function send(): static
    {
        if ($this->getErrors()) {
            return $this;
        }
        if (empty($this->method)) {
            return $this->setErrors(_Errors::error(['Метод не может быть пустым'], $this));
        }
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->url . $this->method,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($this->body),
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
        } catch (Exception $exception) {
//            $this->setErrors(_Errors::exception($exception, $this));
        }
        if ($response['errorCode'] ?? null) {
            return $this->setErrors($response);
        }
        return $this->setData($response ?? []);
    }

    public function setBody(array $body = []): static
    {
        $this->body = array_merge_recursive($this->body, $body);
        return $this;
    }

    public function setReturnUrl(string $url): static
    {
        $this->body['returnUrl'] = config('app.url') . '/' . trim($url, '/');
        return $this;
    }

    public function setMethod(string $method): static
    {
        $this->method = trim($method, '/');
        return $this;
    }

    public static function payInvoice(int $amount, string $number): static
    {
        return (new self())
            ->setMethod('/register.do')
            ->setReturnUrl('/user/invoice-pay')
            ->setBody(['amount' => $amount * 100, 'orderNumber' => $number])
            ->send();
    }

    public static function checkPayInvoice(string $number): static
    {
        return (new self())
            ->setMethod('/getOrderStatus.do')
            ->setBody(['orderId' => $number])
            ->send();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData($data): static
    {
        $this->data = $data ?? [];
        return $this;
    }
}
