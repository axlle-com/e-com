<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Main\Singleton;
use Exception;
use ReflectionClass;
use Throwable;

class _Errors
{
    use Singleton;

    private array $errorsArray = [];
    private string $message = '';
    private string $context = 'Undefined';

    private function __construct() {}

    public static function error(array|string $error, $model = null): static
    {
        $self = self::model();
        if(empty($error)) {
            $error = ['unknown' => 'Oops something went wrong'];
        }
        if(!is_array($error)) {
            $error = (array)$error;
        }
        $classname = null;
        try {
            $classname = $model
                ? (new ReflectionClass($model))->getShortName()
                : null;
        } catch(Exception $exception) {
        }
        if(!empty($model->debug)) {
            $error['debug'] = $model->debug;
        }

        return $self->setErrors($error)
            ->writeError($error, $classname);
    }

    private function writeError(array $data, ?string $classname = null): self
    {
        Logger::model()
            ->error($classname ?? $this->context, $data);

        return $this;
    }

    public static function exception(Throwable $exception, $model = null): static
    {
        $self = self::model();
        $ex = 'Undefined';
        $classname = null;
        try {
            $ex = (new ReflectionClass($exception))->getShortName();
            $classname = $model
                ? (new ReflectionClass($model))->getShortName()
                : null;
        } catch(Exception $exception) {
        }
        $data = [
            'class' => $ex,
            'error' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];

        $self->errorsArray = array_merge($self->errorsArray, ['exception' => $exception->getMessage()]);

        return $self->writeException($data, $classname);
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

    public function setContext($model): static
    {
        try {
            $this->context = (new ReflectionClass($model))->getShortName();
        } catch(Exception $exception) {
        }
        return $this;
    }

    private function writeException(array $data, ?string $classname = null): self
    {
        Logger::model()
            ->group(Logger::GROUP_EXCEPTION)
            ->critical($classname ?? $this->context, $data);

        return $this;
    }

    private function setErrors(array $errors): static
    {
        $this->errorsArray = array_merge($this->errorsArray, $errors);

        return $this;
    }

    private function writeFile(string $name = null, array $body = null): self
    {
        try {
            $path = _create_path('/storage/errors/');
            $nameW = ($name ?? '') . _unix_to_string_moscow(null, '_d_m_Y_') . '.txt';
            $fileW = fopen($path . '/' . $nameW, 'ab');
            fwrite($fileW, '**********************************************************************************' . "\n");
            fwrite($fileW,
                _unix_to_string_moscow() . ' : ' . json_encode($body ?? $this->errorsArray, JSON_UNESCAPED_UNICODE) .
                "\n");
            fclose($fileW);
        } catch(Exception $exception) {
        }

        return $this;
    }
}
