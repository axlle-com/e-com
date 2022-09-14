<?php

namespace App\Common\Models\Errors;

use Throwable;
use Exception;
use ReflectionClass;

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
        $classname = 'Undefined';
        try {
            $classname = (new ReflectionClass($model))->getShortName();
        } catch (Exception $exception) {
        }
        if (!empty($model->debug)) {
            $error['debug'] = $model->debug;
        }

        $self->errorsArray = array_merge($self->errorsArray, $error);
        return $self->writeDB($classname, $error);
    }

    public static function exception(Throwable $exception, $model): static
    {
        $self = self::inst();
        $ex = 'Undefined';
        $classname = 'Undefined';
        try {
            $ex = (new ReflectionClass($exception))->getShortName();
            $classname = (new ReflectionClass($model))->getShortName();
        } catch (Exception $exception) {
        }
        $data = [
            'class' => $ex,
            'error' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];

        $self->errorsArray = array_merge($self->errorsArray, ['exception' => $exception->getMessage()]);
        return $self->writeDB($classname, $data);
    }

    private static function inst(): self
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
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

    private function writeFile(string $name = null, array $body = null): self
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

    private function writeDB(string $classname, array $data): self
    {
        Logger::model()->error($classname, $data);
        return $this;
    }
}
