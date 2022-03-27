<?php

namespace App\Common\Components;

abstract class QueryFilter
{
    private array $request;
    protected $builder;

    public function __construct($request, $builder = null)
    {
        $this->request = $request;
        if ($builder) {
            $this->builder = $builder;
        }
    }

    public function getBuilder(): mixed
    {
        return $this->builder;
    }

    public function setBuilder(mixed $builder): static
    {
        $this->builder = $builder;
        return $this;
    }

    public function apply()
    {
        if ($this->request && is_array($this->request)) {
            foreach ($this->request as $filter => $value) {
                if (method_exists($this, $filter)) {
                    $this->$filter($value);
                }
            }
        }
        return $this->builder;
    }
}
