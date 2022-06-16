<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\UserProfile;

/**
 * This is the model class for table "ax_catalog_payment_type".
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
class CatalogPaymentType extends BaseModel
{
    protected $table = 'ax_catalog_payment_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
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

}
