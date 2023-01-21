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
 *
 * @method Builder joinUrl()
 */
trait HasUrl
{
    public static function withUrl()
    {
        return self::query()->select([
            self::table('*'),
            self::table('alias') . ' as al',
            self::table('url') . ' as ul',
        ])->joinUrl();
    }

    public function scopeJoinUrl(Builder $query): Builder
    {
        $table = $this->getTable();
        $query->addSelect([
            MainUrl::table('url') . ' as url',
            MainUrl::table('alias') . ' as alias',
            MainUrl::table('url_old') . ' as url_old',
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

    public function setAlias(string $alias): static
    {
        /**
         * @var BaseModel $this
         * @var MainUrl $model
         */
        $alias = $this->checkAlias($alias);
        if ($model = MainUrl::query()
                            ->where(MainUrl::table('resource'), $this->getTable())
                            ->where(MainUrl::table('resource_id'), $this->id)
                            ->first()) {
            $model->alias = $alias;
            $model->safe();
        } else if ($this->isDirty() && !$this->safe()->getErrors()) {
            $model = MainUrl::create([
                'resource' => $this->getTable(),
                'resource_id' => $this->id,
                'alias' => $alias,
                'url' => '/' . $alias,
            ]);
        } else if (!$this->getErrors()) {
            $model = MainUrl::create([
                'resource' => $this->getTable(),
                'resource_id' => $this->id,
                'alias' => $alias,
                'url' => '/' . $alias,
            ]);
        }
        if (!$this->getErrors() && $err = $model->getErrors()) {
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
        while (MainUrl::query()->when($id, static function (Builder $builder) use ($id, $table) {
            $builder->where(MainUrl::table('resource'), '!=', $table)->where(MainUrl::table('resource_id'), '!=', $id);
        })->where('alias', $temp)->first()) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }
}
