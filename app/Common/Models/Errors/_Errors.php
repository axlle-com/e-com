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
 * This is the model class for table "{{%ax_main_errors}}".
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
    private array $errors = [];
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

    public static function error($error, $model): static
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
        } elseif ($_SERVER['REMOTE_ADDR']) {
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
        MainErrors::createOrUpdate($data);
        $self->errors = array_merge_recursive($self->errors, $error);
        $self->setMessage(_array_to_string($error));
        if (config('app.log_file')) {
            try {
                $classname = Str::snake((new \ReflectionClass($model))->getShortName());
                $self->writeFile(name: $classname, body: $data);
            } catch (Exception|ReflectionException $exception) {
            }
        }
        return $self;
    }

    public static function exception(\Throwable $exception, $model): static
    {
        $self = self::inst();
        if ($exception === null) {
            return $self;
        }
        $ipsId = null;
        $user = $self->getUser();
        if (!empty($user->ip)) {
            $ipsId = Ips::createOrUpdate(['ip' => $user->ip]);
        } elseif ($_SERVER['REMOTE_ADDR']) {
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
        MainErrors::createOrUpdate($data);
        $self->errors = array_merge_recursive($self->errors, ['exception' => $exception->getMessage()]);
        $self->setMessage('Произошла ошибка уровня Exception');
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
        return $this->message;
    }

    public function getErrors(): array
    {
        return $this->errors;
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
        fwrite($fileW, _unix_to_string_moscow() . ' : ' . json_encode($body ?? $this->errors, JSON_UNESCAPED_UNICODE) . "\n");
        fclose($fileW);
    }

}
