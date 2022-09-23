<?php

namespace App\Common\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Common\Models\User\User;
use Illuminate\Http\JsonResponse;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserWeb;
use App\Common\Models\Errors\Errors;
use App\Common\Models\User\UserRest;
use App\Common\Models\Errors\_Errors;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @property object|null $userJwt Пользователь
 * @property int $status
 * @property string|null $message
 * @property int $status_code
 * @property $data
 * @property Request|null $request
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Errors;

    public const APP_APP = 'app';
    public const APP_REST = 'rest';
    public const APP_WEB = 'web';

    public const STATUS_OK = 200;
    public const ERROR_UNKNOWN = 424; # Failed Dependency
    public const ERROR_UNAUTHORIZED = 401;
    public const ERROR_LOCKED = 423; # Token invalid
    public const ERROR_BAD_REQUEST = 400;
    public const ERROR_NOT_FOUND = 404;
    public const ERROR_BAD_JSON = 406;

    public const MESSAGE_UNKNOWN = 'Failed Dependency';
    public const MESSAGE_UNAUTHORIZED = 'Пользователь не авторизован';
    public const MESSAGE_LOCKED = 'Заблокировано';// Token invalid
    public const MESSAGE_BAD_REQUEST = 'Неправильный запрос или ошибка валидации';
    public const MESSAGE_NOT_FOUND = 'Ресурс не найден';
    public const MESSAGE_BAD_JSON = 'Не валидный json или пустой запрос.';
    protected static array $appsArray = [
        AppController::class => self::APP_APP,
        RestController::class => self::APP_REST,
        WebController::class => self::APP_WEB,
    ];
    private static array $errorsArray = [
        self::ERROR_UNKNOWN => self::MESSAGE_UNKNOWN,
        self::ERROR_UNAUTHORIZED => self::MESSAGE_UNAUTHORIZED,
        self::ERROR_LOCKED => self::MESSAGE_LOCKED,
        self::ERROR_BAD_REQUEST => self::MESSAGE_BAD_REQUEST,
        self::ERROR_NOT_FOUND => self::MESSAGE_NOT_FOUND,
        self::ERROR_BAD_JSON => self::MESSAGE_BAD_JSON,
    ];
    private ?User $user = null;
    private ?object $userJwt = null;
    private int $status = 1;
    private int $status_code = 0;
    private $data = null;
    private ?Request $request = null;
    private array $payload = [];
    private int $startTime;
    private string $appName = '';
    private ?string $token = null;
    private ?string $ip = null;
    private bool $gzip = true;

    public function __construct(Request $request = null)
    {
        $this->startTime = microtime(true);
        if ($request) {
            $this->request = $request;
        }
        if ($this instanceof AppController) {
            $this->setAppName(self::APP_APP);
            $this->user = UserApp::auth();
        }
        if ($this instanceof RestController) {
            $this->setAppName(self::APP_REST);
            $this->user = UserRest::auth();
        }
        if ($this instanceof WebController) {
            $this->setAppName(self::APP_WEB);
        }
    }

    public static function errorStatic(int $code = self::ERROR_UNAUTHORIZED, string $message = null, string $app = 'rest'): JsonResponse
    {
        $array = array_flip(self::$appsArray);
        $model = $array[$app];
        return (new $model)->error($code, $message);
    }

    public function isCookie(): bool
    {
        return isset($_COOKIE['_maps_']) && $_COOKIE['_maps_'] === 'true';
    }

    public function getIp(): ?string
    {
        if (!$this->ip) {
            $this->setIp();
        }
        return $this->ip;
    }

    public function setIp(): Controller
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        return $this;
    }

    public function setConfig(): static
    {
        return $this;
    }

    public function error(int $code = self::ERROR_UNAUTHORIZED, string $message = null): JsonResponse
    {
        $this->setMessage($this->_errors?->getMessage());
        if ($this->status_code) {
            $code = $this->status_code;
        }
        $serverCode = self::STATUS_OK;
        if (!$this instanceof AppController) {
            $serverCode = $code;
        }
        $_message = $this->message ?: (self::$errorsArray[$code] ?? null);
        $_message = $message ?? $_message;
        $this->message = $_message;
        $this->status = 0;
        $this->status_code = $code;
        return response()->json($this->getDataArray(), $serverCode);
    }

    public function getDataArray(array $body = null): array
    {
        $this->debug['time'] = round(microtime(true) - $this->startTime, 4);
        return $body ?? [
                'status' => $this->status,
                'error' => $this->_errors?->getErrors(),
                'message' => $this->message,
                'status_code' => $this->status_code,
                'data' => $this->data,
                'debug' => $this->debug,
            ];
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function setAppName(string $name = 'app'): static
    {
        $this->appName = $name;
        return $this;
    }

    public function setData($body = null): static
    {
        $this->data = $body;
        return $this;
    }

    public function unknown(): static
    {
        $this->status_code = self::ERROR_UNKNOWN;
        return $this;
    }

    public function notFound(): static
    {
        $this->status_code = self::ERROR_NOT_FOUND;
        return $this;
    }

    public function badJson(): static
    {
        $this->status_code = self::ERROR_BAD_JSON;
        return $this;
    }

    public function badRequest(): static
    {
        $this->status_code = self::ERROR_BAD_REQUEST;
        return $this;
    }

    public function locked(): static
    {
        $this->status_code = self::ERROR_LOCKED;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): static
    {
        $this->status_code = $status_code;
        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function getUser(): ?User
    {
        if (!$this->user) {
            $this->setUser();
        }
        return $this->user;
    }

    public function setUser(): static
    {
        if ($this instanceof WebController) {
            $this->user = UserWeb::auth();
        }
        return $this;
    }

    public function getUserJwt(): ?object
    {
        return $this->userJwt;
    }

    public function setUserJwt(): static
    {
        if ($token = $this->getToken()) {
            $this->userJwt = User::setAuthJwt($token);
        }
        return $this;
    }

    public function getToken(): ?string
    {
        if (empty($this->token)) {
            $this->token = $this->request->bearerToken();
        }
        return $this->token;
    }

    public function setToken(): static
    {
        $this->token = $this->request->bearerToken();
        return $this;
    }

    public function setPayload(): static
    {
        if ($this instanceof AppController) {
            $this->body();
        } else {
            $this->request();
        }
        return $this;
    }

    public function body(): array
    {
        if (empty($this->payload) && $this->request) {
            $content = json_decode($this->request->getContent(), true);
            if ($content && is_array($content)) {
                $this->payload = _clear_array($content);
            }
        }
        return $this->payload;
    }

    public function request(): array
    {
        if (empty($this->payload) && $this->request) {
            $content = $this->request->all();
            if ($content && is_array($content)) {
                $this->payload = _clear_array($content);
            }
        }
        return $this->payload;
    }

    public function response(?array $body = null): Response|JsonResponse
    {
        $this->status_code = self::STATUS_OK;
        if ($this->gzip) {
            return $this->gzip($body);
        }
        return response()->json($this->getDataArray($body));
    }

    public function gzip(array $body = null): Response
    {
        $this->status_code = self::STATUS_OK;
        $data = json_encode($this->getDataArray($body));
        $data = gzencode($data, 9);
        return response($data)->withHeaders([
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST',
            'Content-type' => 'application/json; charset=utf-8',
            'Content-Length' => strlen($data),
            'Content-Encoding' => 'gzip',
        ]);
    }

    public function validation(array $rules = null): array
    {
        if ($this instanceof AppController) {
            $data = $this->body();
        } else {
            $data = $this->request();
        }
        if ($data) {
            if (empty($rules)) {
                return $data;
            }
            $validator = Validator::make($data, $rules);
            if ($validator && $validator->fails()) {
                $this->setErrors(_Errors::error($validator->messages()->toArray(), $this));
            } else {
                if ($validator === false) {
                    $this->message = 'Непредвиденная ошибка';
                } else {
                    return $data;
                }
            }
            $this->status_code = self::ERROR_BAD_REQUEST;
            return [];
        }
        $this->status_code = self::ERROR_BAD_JSON;
        return [];
    }

}
