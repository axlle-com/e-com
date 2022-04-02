<?php

namespace App\Common\Http\Controllers;

use App\Common\Models\User\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

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
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public const APP_APP = 'app';
    public const APP_REST = 'rest';
    public const APP_WEB = 'web';


    public const STATUS_OK = 200;
    public const ERROR_UNKNOWN = 424; //Failed Dependency
    public const ERROR_UNAUTHORIZED = 401;
    public const ERROR_LOCKED = 423;// Token invalid
    public const ERROR_BAD_REQUEST = 400;
    public const ERROR_NOT_FOUND = 404;
    public const ERROR_BAD_JSON = 406;

    public const MESSAGE_UNKNOWN = 'Failed Dependency';
    public const MESSAGE_UNAUTHORIZED = 'Пользователь не авторизован';
    public const MESSAGE_LOCKED = 'Заблокировано';// Token invalid
    public const MESSAGE_BAD_REQUEST = 'Неправильный запрос или ошибка валидации';
    public const MESSAGE_NOT_FOUND = 'Ресурс не найден';
    public const MESSAGE_BAD_JSON = 'Не валидный json или пустой запрос.';

    private static array $errorsArray = [
        self::ERROR_UNKNOWN => self::MESSAGE_UNKNOWN,
        self::ERROR_UNAUTHORIZED => self::MESSAGE_UNAUTHORIZED,
        self::ERROR_LOCKED => self::MESSAGE_LOCKED,
        self::ERROR_BAD_REQUEST => self::MESSAGE_BAD_REQUEST,
        self::ERROR_NOT_FOUND => self::MESSAGE_NOT_FOUND,
        self::ERROR_BAD_JSON => self::MESSAGE_BAD_JSON,
    ];

    protected static array $appsArray = [
        AppController::class => self::APP_APP,
        RestController::class => self::APP_REST,
        WebController::class => self::APP_WEB,
    ];
    private ?User $user = null;
    private ?object $userJwt = null;
    private int $status = 1;
    private $errors = null;
    private ?string $message = null;
    private int $status_code = 0;
    private $data = null;
    private ?Request $request;
    private array $payload = [];
    private string $appName = '';
    private ?string $token = null;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
        $this->setConfig();
    }

    public function setConfig(): Controller
    {
        return $this;
    }

    public static function errorStatic(int $code = self::ERROR_UNAUTHORIZED, string $message = null, string $app = 'rest'): JsonResponse
    {
        $array = array_flip(self::$appsArray);
        $model = $array[$app];
        return (new $model)->error($code, $message);
    }

    public function error(int $code = self::ERROR_UNAUTHORIZED, string $message = null): JsonResponse
    {
        if ($this->status_code) {
            $code = $this->status_code;
        }
        $serverCode = self::STATUS_OK;
        if ($this->getAppName() !== self::APP_APP) {
            $serverCode = $code;
        }
        $_message = self::$errorsArray[$code] ?? null;
        $_message = $message ?? $_message;
        $this->message = $_message ?? $this->message;
        $this->status = 0;
        $this->status_code = $code;
        return response()->json($this->getDataArray(), $serverCode);
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function setAppName(string $name = 'app'): Controller
    {
        $this->appName = $name;
        return $this;
    }

    public function getDataArray(array $body = null): array
    {
        return $body ?? [
                'status' => $this->status,
                'error' => $this->errors,
                'message' => $this->message,
                'status_code' => $this->status_code,
                'data' => $this->data,
            ];
    }

    public function setData($body = null): Controller
    {
        $this->data = $body;
        return $this;
    }

    public function unknown(): Controller
    {
        $this->status_code = self::ERROR_UNKNOWN;
        return $this;
    }

    public function notFound(): Controller
    {
        $this->status_code = self::ERROR_NOT_FOUND;
        return $this;
    }

    public function badJson(): Controller
    {
        $this->status_code = self::ERROR_BAD_JSON;
        return $this;
    }

    public function badRequest(): Controller
    {
        $this->status_code = self::ERROR_BAD_REQUEST;
        return $this;
    }

    public function locked(): Controller
    {
        $this->status_code = self::ERROR_LOCKED;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Controller
    {
        $this->status = $status;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Controller
    {
        $this->message = $message;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): Controller
    {
        $this->status_code = $status_code;
        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): Controller
    {
        $this->request = $request;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Controller
    {
        $this->user = $user;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($error): Controller
    {
        $this->errors[] = $error;
        return $this;
    }

    public function getUserJwt(): ?object
    {
        return $this->userJwt;
    }

    public function setUserJwt(): Controller
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

    public function setToken(): Controller
    {
        $this->token = $this->request->bearerToken();
        return $this;
    }

    public function setPayload(): Controller
    {
        if ($this instanceof AppController) {
            $this->body();
        } else {
            $this->request();
        }
        return $this;
    }

    public function request(): array
    {
        if (empty($this->payload)) {
            $content = $this->request->all();
            if ($content && is_array($content)) {
                $this->payload = ax_clear_array($content);
            }
        }
        return $this->payload;
    }

    public function body(): array
    {
        if (empty($this->payload)) {
            $content = json_decode($this->request->getContent(), true);
            if ($content && is_array($content)) {
                $this->payload = ax_clear_array($content);
            }
        }
        return $this->payload;
    }

    public function response(?array $body = null): JsonResponse
    {
        $this->status_code = self::STATUS_OK;
        return response()->json($this->getDataArray($body));
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
                $this->errors = $validator->messages();
            } elseif ($validator === false) {
                $this->message = 'Непредвиденная ошибка';
            } else {
                return $data;
            }
            $this->status_code = self::ERROR_BAD_REQUEST;
            return [];
        }
        $this->status_code = self::ERROR_BAD_JSON;
        return [];
    }

}
