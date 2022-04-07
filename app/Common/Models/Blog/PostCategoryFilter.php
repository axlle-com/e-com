<?php

namespace App\Common\Models\Blog;

use App\Common\Components\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class PostCategoryFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            'ax_post_category.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_post_category as par', 'ax_post_category.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_post_category.render_id', '=', 'ren.id');
        return $this;
    }

    public function _gallery(): Builder
    {
        $this->builder->select([
            'ax_post_category.*',
            'ax_gallery.id as gallery_id',
        ])
            ->leftJoin('ax_gallery_has_resource as has', 'has.resource_id', '=', 'ax_post_category.id')
            ->where('has.resource', 'ax_post_category')
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
