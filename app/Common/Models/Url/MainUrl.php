<?php

namespace App\Common\Models\Url;

use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%main_url}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property string $alias
 * @property string $url
 * @property string $url_old
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class MainUrl extends BaseModel
{
    use HasHistory;

    protected $table = 'ax_main_url';
    protected $fillable = [
        'resource',
        'resource_id',
        'alias',
        'url',
        'url_old',
        'deleted_at',
    ];

    protected static function boot()
    {
        self::creating(static function(self $model) {});
        self::created(static function(self $model) {});
        self::updating(static function(self $model) {});
        self::updated(static function(self $model) {});
        self::deleting(static function(self $model) {});
        self::deleted(static function(self $model) {});
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public function setUrl(string $alias = null): static
    {
        $this->url = $alias ?? $this->alias;

        return $this;
    }

    public function setResource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function setResourceId(int $id): static
    {
        $this->resource_id = $id;

        return $this;
    }
}
