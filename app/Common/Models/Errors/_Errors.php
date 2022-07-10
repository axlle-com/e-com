<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Str;
use PHPUnit\Util\Exception;
use ReflectionException;

/**
 *
 * @property int $id
 * @property int $errors_type_id
 * @property int|null $user_id
 * @property int|null $ips_id
 * @property string|null $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class _Errors
{
    private array $errorsArray = [];
    private string $message = '';
    private static self $_inst;

    private function __construct()
    {
    }

    private static function inst(): self
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
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
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipsId = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR']]);
        }
        $classname = Str::snake((new \ReflectionClass($model))->getShortName());
        $data = [
            'model' => $classname,
            'user_id' => $user->id ?? null,
            'ips_id' => $ipsId->id ?? null,
            'errors_type_id' => MainErrorsType::query()->where('name', 'error')->first()->id ?? null,
            'body' => $error,
        ];
        $self->errorsArray = array_unique(array_merge($self->errorsArray, $error));
        try {
            MainErrors::createOrUpdate($data);
        } catch (Exception $exception) {
        }
        if (config('app.log_file')) {
            try {
                $self->writeFile(name: $classname, body: $data);
            } catch (Exception) {
            }
        }
        return $self;
    }

    public static function exception(\Throwable $exception, $model): static
    {
        $self = self::inst();
        $ipsId = null;
        $user = $self->getUser();
        if (!empty($user->ip)) {
            $ipsId = Ips::createOrUpdate(['ip' => $user->ip]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipsId = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR']]);
        }
        $ex = class_basename($exception);
        $classname = Str::snake((new \ReflectionClass($model))->getShortName());
        $body = [
            'class' => $ex,
            'error' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];
        $data = [
            'model' => $classname,
            'user_id' => $user->id ?? null,
            'ips_id' => $ipsId->id ?? null,
            'errors_type_id' => MainErrorsType::query()->where('name', 'exception')->first()->id ?? null,
            'body' => $body,
        ];
        $self->errorsArray = array_unique(array_merge($self->errorsArray, ['exception' => $exception->getMessage()]));
        try {
            MainErrors::createOrUpdate($data);
        } catch (Exception $exception) {
        }
        if (config('app.log_file')) {
            try {
                $self->writeFile(name: $classname, body: $body);
            } catch (Exception $exception) {
            }
        }
        return $self;
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');
        return $this;
    }

    public function getMessage(): string
    {
        return _array_to_string($this->getErrors());
    }

    public function getErrors(): array
    {
        return $this->errorsArray;
    }

    private function getUser()
    {
        if (UserWeb::auth()) {
            $user = UserWeb::auth();
        } elseif (UserRest::auth()) {
            $user = UserRest::auth();
        } elseif (UserApp::auth()) {
            $user = UserApp::auth();
        }
        return $user ?? null;
    }

    private function createPath(string $path = ''): string
    {
        $dir = base_path($path);
        if (!file_exists($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
        return $dir;
    }

    private function writeFile(string $path = '', string $name = '', array $body = null): void
    {
        $path = $this->createPath('/storage/errors/' . $path);
        $nameW = ($name ?? '') . _unix_to_string_moscow(null, '_d_m_Y_') . '.txt';
        $fileW = fopen($path . '/' . $nameW, 'ab');
        fwrite($fileW, '**********************************************************************************' . "\n");
        fwrite($fileW, _unix_to_string_moscow() . ' : ' . json_encode($body ?? $this->errorsArray, JSON_UNESCAPED_UNICODE) . "\n");
        fclose($fileW);
    }

}
