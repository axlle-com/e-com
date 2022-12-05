<?php

namespace App\Common\Models\Main;

trait Singleton
{
    private static array $_inst;

    public static function model(array $_attributes = []): static
    {
        if (empty(static::$_inst[static::class])) {
            static::$_inst[static::class] = new static($_attributes);
        }
        return static::$_inst[static::class];
    }
}
