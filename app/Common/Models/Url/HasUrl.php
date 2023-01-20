<?php

namespace App\Common\Models\Url;

use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Query;

/**
 *
 * @property string $alias
 * @property string $url
 * @property string $url_old
 */
trait HasUrl
{
    public function scopeJoinUrl(Builder $query): Builder
    {
        $table = $this->getTable();
        $query->addSelect([
            'url as url',
            'alias as alias',
            'url_old as url_old',
        ])->leftJoin(MainUrl::table(), static function ($join) use ($table) {
            /** @var Query $join */
            $join->on('ev.resource_id', '=', $table . '.id')->where('ev.resource', '=', $table);
        });
        return $query;
    }

    public function getUrl(): ?string
    {
        if ($this instanceof CatalogCategory || $this instanceof CatalogProduct) {
            return '/catalog/' . $this->url;
        }
        return $this->url;
    }

    public function setAlias(array $data = []): static
    {
        /* @var $this BaseModel */
        if (empty($data['alias'])) {
            $alias = _set_alias($this->title);
            $this->alias = $this->checkAlias($alias);
        } else {
            $this->alias = $this->checkAlias($data['alias']);
        }
        $this->url = $this->alias;
        return $this;
    }

    protected function checkAlias(string $alias): string
    {
        $cnt = 1;
        $temp = $alias;
        while (MainUrl::query()->where('alias', $temp)->first()) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }
}
