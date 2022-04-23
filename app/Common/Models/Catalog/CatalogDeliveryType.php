<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\UserProfile;

/**
 * This is the model class for table "ax_catalog_delivery_type".
 *
 * @property int $id
 * @property int $is_active
 * @property string $title
 * @property string $alias
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogDocument[] $catalogDocuments
 * @property UserProfile[] $userProfiles
 */
class CatalogDeliveryType extends BaseModel
{
    protected $table = 'ax_catalog_delivery_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $post = self::query()
            ->where('alias', $alias)
            ->when($id, function ($query, $id) {
                $query->where('id', '!=', $id);
            })->first();
        if ($post) {
            return true;
        }
        return false;
    }

    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::class, ['catalog_delivery_type_id' => 'id']);
    }

    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::class, ['catalog_delivery_type_id' => 'id']);
    }
}
