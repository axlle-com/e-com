<?php

namespace App\Common\Models\Catalog;

use App\Common\Components\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CatalogCategoryFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            'ax_catalog_category.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_catalog_category as par', 'ax_catalog_category.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_catalog_category.render_id', '=', 'ren.id');
        return $this;
    }

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
