<?php

namespace App\Common\Components;

use App\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * This is class for filter "QueryFilter".
 *
 * @property array request
 * @property array $safeFields
 * @property Builder $builder
 * @property BaseModel|null parentModel
 *
 */
abstract class QueryFilter
{
    private array $request;
    protected Builder $builder;
    protected BaseModel $parentModel;
    protected string $table;
    protected array $safeFields = [];

    public function __construct(array $request, string $model = null)
    {
        $this->request = $request;
        if ($model) {
            $this->parentModel = new $model();
            $this->builder = $this->parentModel::query();
            $this->table = $this->parentModel::tableSQL();
        }
    }

    public function _gallery(): Builder
    {
        $this->builder->select([
            'ax_post.*',
            'ax_gallery.id as gallery_id',
        ])
            ->leftJoin('ax_gallery_has_resource as has', function ($leftJoin) {
                $leftJoin
                    ->on('has.resource_id', '=', 'ax_post.id')
                    ->on('has.resource', '=', DB::raw($this->table));
            })
            ->leftJoin('ax_gallery', function ($leftJoin) {
                $leftJoin
                    ->on('has.gallery_id', '=', 'ax_gallery.id')
                    ->where('ax_gallery.id', '=', DB::raw("(select id from ax_gallery where ax_gallery.id=has.gallery_id limit 1)"));
            });
        return $this->builder;
    }

    public function getBuilder(): ?Builder
    {
        return $this->builder;
    }

    public function setBuilder(Builder $builder): static
    {
        $this->builder = $builder;
        return $this;
    }

    public function apply(): Builder
    {
        if ($this->request) {
            foreach ($this->request as $filter => $value) {
                if (method_exists($this, $filter) && in_array($filter, $this->safeFields, true)) {
                    $this->$filter($value);
                }
            }
        }
        return $this->builder;
    }

    public function _filter(): static
    {
        return $this;
    }

    public function category_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.category_id', $value);
    }

    public function render_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.render_id', $value);
    }

    public function is_published(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.is_published', $value);
    }

    public function is_favourites(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.is_favourites', $value);
    }

    public function title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.title', 'ilike', '%' . $value . '%');
    }

    public function description(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where($this->table . '.description', 'ilike', '%' . $value . '%');
    }
}
