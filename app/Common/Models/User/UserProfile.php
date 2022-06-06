<?php

namespace App\Common\Models\User;

use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "ax_user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $catalog_delivery_type_id
 * @property int|null $catalog_payment_type_id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogDeliveryType $catalogDeliveryType
 * @property CatalogPaymentType $catalogPaymentType
 * @property User $user
 */
class UserProfile extends BaseModel
{
    protected $table = 'ax_user_profile';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
