<?php

namespace App\Common\Models\Main;

use Illuminate\Support\Str;
use PHPUnit\Util\Exception;

trait Errors
{
    private array $errors = [];

    public static function sendErrors(array $error = null): static
    {
        return (new static())->setErrors($error);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $error = null): static
    {
        if (empty($error)) {
            $error = ['unknown' => 'Oops something went wrong in [ ' . static::class . ' ]'];
        }
        $this->status = 0;
        $this->errors = array_merge_recursive($this->errors, $error);
        if (env('APP_LOG_FILE', false)) {
            try {
                $classname = Str::snake((new \ReflectionClass($this))->getShortName());
                $this->writeFile(name: $classname);
            } catch (Exception $exception) {
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

    private function writeFile(string $path = '', string $name = ''): void
    {
        $path = $this->createPath('/storage/errors/' . $path);
        $nameW = ($name ?? '') . _unix_to_string_moscow(null, '_d_m_Y_') . '.txt';
        $fileW = fopen($path . '/' . $nameW, 'ab');
        fwrite($fileW, '**********************************************************************************' . "\n");
        fwrite($fileW, _unix_to_string_moscow() . ' : ' . json_encode($this->errors, JSON_UNESCAPED_UNICODE) . "\n");
        fclose($fileW);
    }
}
