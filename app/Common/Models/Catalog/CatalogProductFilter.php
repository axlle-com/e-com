<?php

namespace App\Common\Models\Catalog;

use App\Common\Components\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CatalogProductFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            'ax_catalog_product.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_catalog_category as par', 'ax_catalog_product.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_catalog_product.render_id', '=', 'ren.id');
        return $this;
    }

    public function _gallery(): Builder
    {
        $this->builder->select([
            'ax_catalog_product.*',
            'ax_gallery.id as gallery_id',
        ])
            ->leftJoin('ax_gallery_has_resource as has', 'has.resource_id', '=', 'ax_catalog_product.id')
            ->where('has.resource', 'ax_catalog_product')
            ->leftJoin('ax_gallery', 'has.gallery_id', '=', 'ax_gallery.id');;
        return $this->builder;
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