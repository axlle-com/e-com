<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_catalog_delivery_status".
 *
 * @property int $id
 * @property string $title
 * @property string $key
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class CatalogDeliveryStatus extends BaseModel
{
    protected $table = 'ax_catalog_delivery_status';
}
