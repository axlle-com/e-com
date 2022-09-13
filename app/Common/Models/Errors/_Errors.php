<?php

namespace App\Common\Models\Errors;

use Throwable;
use Exception;
use ReflectionClass;
use App\Common\Models\Ips;
use Illuminate\Support\Str;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserWeb;
use App\Common\Models\User\UserRest;

class _Errors
{
    private static self $_inst;
    private array $errorsArray = [];
    private string $message = '';

    private function __construct()
    {
    }

    public static function error(array|string $error, $model): static
    {
        $self = self::inst();
        if (empty($error)) {
            $error = ['unknown' => 'Oops something went wrong'];
        }
        if (!is_array($error)) {
            $error = (array)$error;
        }
        $user = $self->getUser();
        $ipsId = null;
        if (!empty($user->ip)) {
            $ipsId = Ips::createOrUpdate(['ip' => $user->ip]);
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipsId = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR']]);
        }
        $classname = Str::snake((new ReflectionClass($model))->getShortName());
        if (!empty($model->debug)) {
            $error['debug'] = $model->debug;
        }
        $data = [
            'model' => $classname,
            'model_id' => $model->id ?? null,
            'user_id' => $user->id ?? null,
            'ips_id' => $ipsId->id ?? null,
            'errors_type_id' => MainErrorsType::query()->where('name', 'error')->first()->id ?? null,
            'body' => $error,
        ];

        $self->errorsArray = array_merge($self->errorsArray, $error);
        return $self->writeDB($data)->writeFile($classname, $data);
    }

    private static function inst(): self
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
    }

    private function getUser()
    {
        if (UserWeb::auth()) {
            $user = UserWeb::auth();
        } else if (UserRest::auth()) {
            $user = UserRest::auth();
        } else if (UserApp::auth()) {
            $user = UserApp::auth();
        }
        return $user ?? null;
    }

    private function writeFile(string $name = '', array $body = null): self
    {
        if (config('app.log_file')) {
            try {
                $path = _create_path('/storage/errors/');
                $nameW = ($name ?? '') . _unix_to_string_moscow(null, '_d_m_Y_') . '.txt';
                $fileW = fopen($path . '/' . $nameW, 'ab');
                fwrite($fileW, '**********************************************************************************' . "\n");
                fwrite($fileW, _unix_to_string_moscow() . ' : ' . json_encode($body ?? $this->errorsArray, JSON_UNESCAPED_UNICODE) . "\n");
                fclose($fileW);
            } catch (Exception $exception) {
            }
        }
        return $this;
    }

    private function writeDB(array $data = null): self
    {
        try {
            MainErrors::createOrUpdate($data);
        } catch (Exception $exception) {
        }
        return $this;
    }

    public static function exception(Throwable $exception, $model): static
    {
        $self = self::inst();
        $ipsId = null;
        $user = $self->getUser();
        if (!empty($user->ip)) {
            $ipsId = Ips::createOrUpdate(['ip' => $user->ip]);
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipsId = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR']]);
        }
        $ex = (new ReflectionClass($exception))->getShortName();
        $classname = Str::snake((new ReflectionClass($model))->getShortName());
        $body = [
            'class' => $ex,
            'error' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];
        $data = [
            'model' => $classname,
            'model_id' => $model->id ?? null,
            'user_id' => $user->id ?? null,
            'ips_id' => $ipsId->id ?? null,
            'errors_type_id' => MainErrorsType::query()->where('name', 'exception')->first()->id ?? null,
            'body' => $body,
        ];
        $self->errorsArray = array_merge($self->errorsArray, ['exception' => $exception->getMessage()]);
        return $self->writeDB($data)->writeFile($classname, $body);
    }

    public function getMessage(): string
    {
        return _array_to_string($this->getErrors());
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errorsArray;
    }
}
