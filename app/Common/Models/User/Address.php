<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_main_address".
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
    protected $table = 'ax_main_address';
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

    public static function createOrUpdate(array $post): self
    {
        $is_delivery = $post['is_delivery'] ?? null;
        if ($is_delivery) {
            unset($post['is_delivery']);
        }
        $self = self::query();
        foreach ($post as $key => $value) {
            $self->where($key, 'like', '%' . $value . '%');
        }
        $self = $self->first();
        /* @var $self self */
        if ($self) {
            if (!$self->is_delivery) {
                $selfBefore = self::query()
                                  ->where('is_delivery', 1)
                                  ->where('resource', $post['resource'])
                                  ->where('resource_id', $post['resource_id'])
                                  ->where('id', '!=', $self->id)
                                  ->update(['is_delivery' => 0]);
                $self->is_delivery = 1;
                return $self->safe();
            }
            return $self;
        }
        if ($is_delivery) {
            $self = self::query()
                        ->where('is_delivery', 1)
                        ->where('resource', $post['resource'])
                        ->where('resource_id', $post['resource_id'])
                        ->update(['is_delivery' => 0]);
            $post['is_delivery'] = $is_delivery;
        }
        return (new self($post))->safe();
    }
}
