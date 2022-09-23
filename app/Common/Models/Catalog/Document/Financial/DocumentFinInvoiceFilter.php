<?php

namespace App\Common\Models\Catalog\Document\Financial;

use App\Common\Models\Main\QueryFilter;

class DocumentFinInvoiceFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([$this->table('*'),]);
        return $this;
    }
}
