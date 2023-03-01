<?php

namespace App\Common\Models;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_main_seo}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Ips $ips
 */
class Seo extends BaseModel
{
    protected $table = 'ax_main_seo';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public static function _createOrUpdate(array $post, BaseModel $model): Seo # TODO: !!!
    {
        $self = self::query()->where('resource', $model->getTable())->where('resource_id', $model->id)->first();
        if(!$self) {
            $self = new self();
            $self->resource_id = $model->id;
            $self->resource = $model->getTable();
        }
        $self->title = $post['title'];
        $self->description = $post['description'];
        return $self->safe();
    }
}
