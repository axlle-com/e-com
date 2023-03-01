<?php

namespace App\Common\Models\Main;

trait Singleton
{
    private static array $_inst;

    public function __construct(array $_attributes = [])
    {
        if(method_exists($this, 'init')) {
            $this->init();
        }
        if($_attributes && method_exists($this, 'load')) {
            $this->load($_attributes);
        }
    }

    public static function model(array $_attributes = []): static
    {
        if(empty(static::$_inst[static::class])) {
            static::$_inst[static::class] = new static($_attributes);
        } else if($_attributes && method_exists(static::$_inst[static::class], 'load')) {
            static::$_inst[static::class]->load($_attributes);
        }
        return static::$_inst[static::class];
    }
}
