<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Str;

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

    public static function error($error, BaseModel $model): static
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
            'body' => json_encode($error, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
        ];
        MainErrors::createOrUpdate($data);
        $self->errors = array_merge_recursive($self->errors, $error);
        $self->setMessage(_array_to_string($error));
        return $self;
    }

    public static function exception(\Throwable $exception, BaseModel $model): static
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
            'body' => json_encode($body, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
        ];
        MainErrors::createOrUpdate($data);
        $self->errors = array_merge_recursive($self->errors, ['exception' => $exception->getMessage()]);
        $self->setMessage('Произошла ошибка уровня Exception');
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
}
