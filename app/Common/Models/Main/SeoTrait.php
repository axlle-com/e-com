<?php

namespace App\Common\Models\Main;

use App\Common\Models\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $title_seo
 * @property string|null $description_seo
 */
trait SeoTrait
{
    public ?Seo $seo;

    public function setSeo(array $post): static
    {
        /* @var $this BaseModel */
        $post['title'] = $post['title'] ?? null;
        $post['description'] = $post['description'] ?? null;
        $this->seo = Seo::createOrUpdate($post, $this);
        return $this;
    }

    public static function withSeo(): Builder
    {
        return static::query()
            ->select([
                static::table('*'),
                Seo::table('title') . ' as title_seo',
                Seo::table('description') . ' as description_seo',
            ])
            ->leftJoin(Seo::table(), static function ($join) {
                $join->on(Seo::table('resource_id'), '=', static::table('id'))
                    ->where(Seo::table('resource'), '=', static::table());
            });
    }

    public static function one(int $id): Builder
    {
        return static::withSeo()->where(static::table('id'), $id);
    }

    public static function oneWith(int $id, array $relation): ?Model
    {
        return static::withSeo()->where(static::table('id'), $id)->with($relation)->first();
    }

    # TODO: make better
    public function safe(): static
    {
        try {
            !$this->getErrors() && $this->save();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
            $this->setErrors(['exception' => $error . ' in [ ' . static::class . ' ] ' . $exception->getLine() . ($exception->getTraceAsString())]);
        }
        if (isset($this->seo)) {
            $this->title_seo = $this->seo->title;
            $this->description_seo = $this->seo->description;
        }
        return $this;
    }
}
