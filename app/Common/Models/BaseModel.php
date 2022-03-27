<?php

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public const MESSAGE_UNKNOWN = ['default' => 'Произошла не предвиденная ошибка'];

    private array $error = [];

    public static function sendError(array $error = self::MESSAGE_UNKNOWN): static
    {
        return (new static())->setError($error);
    }

    public function getError(): array
    {
        return $this->error;
    }

    public function setError(array $error = self::MESSAGE_UNKNOWN): static
    {
        $this->error[] = $error;
        return $this;
    }
}
