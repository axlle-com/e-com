<?php

namespace App\Common\Models\Errors;

use Illuminate\Support\Str;
use PHPUnit\Util\Exception;
use ReflectionClass;
use function _array_to_string;
use function _unix_to_string_moscow;
use function base_path;
use function class_basename;
use function config;

/**
 * This is the model class for storage.
 *
 * @property array|null errors
 * @property string|null $message
 */
trait Errors
{
    private array $errors = [];
    public string $message = '';
    private ?_Errors $_errors = null;

    public static function sendErrors(array $error = null): static
    {
        return (new static())->setErrors($error);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(mixed $error = null): static
    {
        if (empty($error)) {
            $error = ['unknown' => 'Oops something went wrong'];
        }
        if (!is_array($error)) {
            $error = (array)$error;
        }
        if (property_exists($this, 'status')) {
            $this->status = 0;
        }
        if (property_exists($this, 'status_code')) {
            $this->status_code = 400;
        }
        $this->errors = array_merge_recursive($this->errors, $error);
        if (method_exists($this, 'setMessage')) {
            $this->setMessage(_array_to_string($this->errors));
        } else {
            $this->message .= '|' . _array_to_string($this->errors);
            $this->message = trim($this->message, '| ');
        }
        if (config('app.log_file')) {
            try {
                $classname = Str::snake((new ReflectionClass($this))->getShortName());
                $this->writeFile(name: $classname);
            } catch (Exception $exception) {
            }
        }
        return $this;
    }

    public function _setErrors(_Errors $error): static
    {
        $this->_errors = $error;
        return $this;
    }

    public function _getErrors(): ?_Errors
    {
        return $this->_errors;
    }

    public function _getErrorsArray(): ?array
    {
        return $this->_errors ? $this->_errors->getErrors() : [];
    }

    public function _getMessage(): ?string
    {
        return $this->_errors ? $this->_errors->getMessage() : '';
    }

    public function setException($exception): static
    {
        $this->setErrors('Произошла ошибка уровня Exception');
        if (!empty($exception)) {
            $error = $exception->getMessage();
            $line = $exception->getLine();
            $trace = $exception->getTrace();
            if (config('app.log_file')) {
                try {
                    $ex = class_basename($exception);
                    $classname = Str::snake((new ReflectionClass($this))->getShortName());
                    $this->writeFile(name: $classname, body: [$ex => $error . ' in [ ' . static::class . ' ] ' . $line]);
                } catch (Exception $exception) {
                }
            }
        }
        return $this;
    }

    public function getErrorsString(): ?string
    {
        return $this->errors ? json_encode($this->errors, JSON_UNESCAPED_UNICODE) : null;
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