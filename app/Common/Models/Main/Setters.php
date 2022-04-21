<?php

namespace App\Common\Models\Main;

trait Setters
{
    private array $errors = [];
    private int $status = 1;

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
        return $this;
    }

    public function getErrorsString(): ?string
    {
        return $this->errors ? json_encode($this->errors) : null;
    }
}
