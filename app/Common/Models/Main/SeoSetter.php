<?php

namespace App\Common\Models\Main;

use Throwable;
use App\Common\Models\Seo;
use App\Common\Models\Errors\_Errors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string|null $title_seo
 * @property string|null $description_seo
 */
trait SeoSetter
{
    public ?Seo $seo;

    public static function one(int $id): Builder
    {
        return static::withSeo()->where(static::table('id'), $id);
    }

    public static function withSeo(): Builder
    {
        return static::query()->select([
            static::table('*'),
            Seo::table('title') . ' as title_seo',
            Seo::table('description') . ' as description_seo',
        ])->leftJoin(Seo::table(), static function ($join) {
            $join->on(Seo::table('resource_id'), '=', static::table('id'))
                ->where(Seo::table('resource'), '=', static::table());
        });
    }

    public static function oneWith(int $id, array $relation): ?Model
    {
        return static::withSeo()->where(static::table('id'), $id)->with($relation)->first();
    }

    public function setSeo(array $post): static
    {
        /* @var $this BaseModel */
        $post['title'] = $post['title'] ?? null;
        $post['description'] = $post['description'] ?? null;
        $this->seo = Seo::createOrUpdate($post, $this);
        return $this;
    }

    # TODO: make better
    public function safe(): static
    {
        try {
            !$this->getErrors() && $this->save();
        } catch (Throwable $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        if (isset($this->seo)) {
            $this->title_seo = $this->seo->title;
            $this->description_seo = $this->seo->description;
        }
        return $this;
    }
}
