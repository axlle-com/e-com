<?php

namespace App\Common\Models\Page;

use App\Common\Components\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class PageFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            'ax_page.*',
            'par.title as type_title',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_page_type as par', 'ax_page.page_type_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_page.render_id', '=', 'ren.id');
        return $this;
    }
    # TODO: пофиксить а то может прилететь коллекция
    public function _gallery(): Builder
    {
        $this->builder->select([
            'ax_page.*',
            'ax_gallery.id as gallery_id',
        ])
            ->leftJoin('ax_gallery_has_resource as has', function ($leftJoin) {
                $leftJoin
                    ->on('has.resource_id', '=', 'ax_page.id')
                    ->on('has.resource', '=', Page::tableSQL());
            })
            ->leftJoin('ax_gallery', 'has.gallery_id', '=', 'ax_gallery.id');
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
