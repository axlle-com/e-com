<?php

namespace App\Common\Models\Main;

use Exception;
use App\Common\Models\Errors\Logger;
use App\Common\Models\Errors\_Errors;
use Illuminate\Support\Facades\Http;

/**
 *
 */
trait BaseHttp
{
    private array $_response;
    private int $_time = 30;
    private ?string $_token = null;
    private ?string $_path = null;
    private ?array $_body = null;

    public function post(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->_token, 'Token')
                ->timeout($this->_time)
                ->post($url ?? $this->_path, $body ?? $this->_body);
        } catch (Exception $exception) {
            if (method_exists($this, 'setErrors')) {
                $this->setErrors(_Errors::exception($exception, $this));
            } else {
                Logger::model()->error($this::class, $exception->getTrace());
            }
        }
        if (isset($response) && $response->successful()) {
            $this->_response = $response->json();
        }
        return $this;
    }

    public function get(array $body = null, string $url = null): self
    {
        $response = null;
        try {
            $response = Http::withToken($this->_token, 'Token')
                ->timeout($this->_time)
                ->get($url ?? $this->_path, $body ?? $this->_body);
        } catch (Exception $exception) {
            if (method_exists($this, 'setErrors')) {
                $this->setErrors(_Errors::exception($exception, $this));
            } else {
                Logger::model()->error($this::class, $exception->getTrace());
            }
        }
        if (isset($response) && $response->successful()) {
            $this->_response = $response->json();
        }
        return $this;
    }

    public function getResponse(): ?array
    {
        return $this->_response;
    }

    public function setResponse(?array $response): self
    {
        $this->_response = $response;
        return $this;
    }

    public function getTime(): int
    {
        return $this->_time;
    }

    public function setTime(int $time): self
    {
        $this->_time = $time;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->_token;
    }

    public function setToken(?string $token): self
    {
        $this->_token = $token;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->_path;
    }

    public function setPath(?string $path): self
    {
        $this->_path = $path;
        return $this;
    }

    public function getBody(): ?array
    {
        return $this->_body;
    }

    public function setBody(?array $body): self
    {
        $this->_body = $body;
        return $this;
    }
}
