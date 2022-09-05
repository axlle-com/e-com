<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Catalog\CatalogDeliveryType;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public static function createOrUpdate(array $post): static
    {
        if (!$user = self::query()->find($post['user_id'])) {
            $user = new static();
        }
        $user->loadModel($post);
        return $user->safe();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Address::class, Address::table('resource_id'), 'id')
            ->where(Address::table('resource'), self::table());
    }

    public function setAddress(): static
    {

        return $this;
    }


}
