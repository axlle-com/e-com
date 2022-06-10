<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_address".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property int $type
 * @property int $is_delivery
 * @property int|null $index
 * @property string|null $country
 * @property string|null $region
 * @property string|null $city
 * @property string|null $street
 * @property string|null $house
 * @property string|null $apartment
 * @property string|null $description
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class Address extends BaseModel
{
    protected $table = 'ax_address';
    protected $fillable = [
        'id',
        'resource',
        'resource_id',
        'type',
        'is_delivery',
        'index',
        'country',
        'region',
        'city',
        'street',
        'house',
        'apartment',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(array $post): self
    {
        $self = self::query();
        foreach ($post as $key => $value) {
            $self->where($key, 'like', '%' . $value . '%');
        }
        $self = $self->first();
        /* @var $self self */
        if ($self) {
            return $self;
        }
        return (new self($post))->safe();
    }
}
