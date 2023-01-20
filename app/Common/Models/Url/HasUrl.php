<?php

namespace App\Common\Models\Url;

use App\Common\Models\Catalog\BaseCatalog;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Query;

/**
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
        ])->leftJoin(MainUrl::table(), static function (Query $join) use ($table) {
            $join->on(MainUrl::table('resource_id'), '=', $table . '.id')
                 ->where(MainUrl::table('resource'), '=', $table);
        });
        return $query;
    }

    public function getUrl(): ?string
    {
        if ($this instanceof BaseCatalog) {
            return '/catalog/' . $this->url;
        }
        return $this->url;
    }

    public function setAlias(string $data = ''): static
    {
        /** @var $this BaseModel */
        if (empty($data)) {
            $alias = _set_alias($this->title);
            $alias = $this->checkAlias($alias);
        } else {
            $alias = $this->checkAlias($data);
        }
        /** @var MainUrl $model */
        if ($model = MainUrl::query()
                            ->where(MainUrl::table('resource'), $this->getTable())
                            ->where(MainUrl::table('resource_id'), $this->id)
                            ->first()) {
            $model->alias = $alias;
        } else {
            $model = MainUrl::create([
                'resource' => $this->getTable(),
                'resource_id' => $this->id,
                'alias' => $alias,
            ]);
        }
        if ($err = $model->setUrl()->safe()->getErrors()) {
            $this->setErrors($err);
        }
        return $this;
    }

    public function setUrl(string $alias): static
    {
        $this->url = $this->alias;
        return $this;
    }

    protected function checkAlias(string $alias): string
    {
        $cnt = 1;
        $temp = $alias;
        $id = $this->id;
        $table = $this->getTable();
        while (MainUrl::query()->when($id, static function (Query $builder) use ($id, $table) {
            $builder->where(MainUrl::table('resource'), '!=', $table)->where(MainUrl::table('resource_id'), '!=', $id);
        })->where('alias', $temp)->first()) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }
}
