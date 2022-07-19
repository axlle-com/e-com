<?php

namespace App\Common\Models\Errors;

/**
 * This is the model class for errors.
 *
 * @property array|null errors
 * @property string|null $message
 */
trait Errors
{
    public string $message = '';
    private ?_Errors $errors = null;

    public static function sendErrors(array $error = null): static
    {
        return (new static())->setErrors(_Errors::error($error, new self()));
    }

    public function getErrors(): ?_Errors
    {
        return $this->errors;
    }

    public function setErrors(_Errors $error): static
    {
        if (property_exists($this, 'status')) {
            $this->status = 0;
        }
        if (property_exists($this, 'status_code')) {
            $this->status_code = 400;
        }
        $this->errors = $error;
        return $this;
    }

    public function getErrorsString(): ?string
    {
        return $this->errors ? json_encode($this->errors->getErrors(), JSON_UNESCAPED_UNICODE) : null;
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');
        return $this;
    }
}
