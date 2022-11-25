<?php

namespace App\Common\Models\Main;

trait Singleton
{
    private static self $_inst;

    public static function model(array $_attributes = []): static
    {
        if (empty(static::$_inst)) {
            self::$_inst = new static($_attributes);
        }
        return static::$_inst;
    }
}
