<?php

namespace App\Common\Models\Catalog;

use App\Common\Components\QueryFilter;

class CatalogCategoryFilter extends QueryFilter
{
    public function category(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('category_id', $value);
    }

    public function render(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('render_id', $value);
    }

    public function published(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('is_published', $value);
    }

    public function favourites(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('is_favourites', $value);
    }

    public function title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('title', 'ilike', '%' . $value . '%');
    }

    public function description(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('description', 'ilike', '%' . $value . '%');
    }
}
