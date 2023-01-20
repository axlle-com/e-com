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
    private mixed $debug;
    private ?_Errors $_errors = null;

    public static function sendErrors(array $error = null): static
    {
        return (new static())->setErrors(_Errors::error($error, new self()));
    }

    public function getErrorsString(): ?string
    {
        return $this->_errors ? json_encode($this->_errors->getErrors(), JSON_UNESCAPED_UNICODE) : null;
    }

    public function getErrors(): ?_Errors
    {
        return $this->_errors;
    }

    public function setErrors(_Errors $error): static
    {
        if (property_exists($this, 'status')) {
            $this->status = 0;
        }
        if (property_exists($this, 'status_code')) {
            $this->status_code = 400;
        }
        $this->_errors = $error;
        return $this;
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebug(): mixed
    {
        return $this->debug;
    }

    /**
     * @param mixed $debug
     * @return Errors
     */
    public function setDebug(mixed $debug): static
    {
        $this->debug = $debug;
        return $this;
    }


}
