<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Catalog\UnitOkei;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "ax_catalog_property_unit".
 *
 * @property int $id
 * @property int $catalog_property_id
 * @property int|null $unit_okei_id
 * @property string $title
 * @property string|null $national_symbol
 * @property string|null $international_symbol
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProperty $catalogProperty
 * @property UnitOkei $unitOkei
 * @property CatalogPropertyValue[] $catalogPropertyValues
 */
class CatalogPropertyUnit extends BaseModel
{
    protected $table = 'ax_catalog_property_unit';

    public function catalogProperty(): BelongsTo
    {
        return $this->belongsTo(CatalogProperty::class, 'catalog_property_id', 'id');
    }

    public function unitOkei(): BelongsTo
    {
        return $this->belongsTo(UnitOkei::class, 'unit_okei_id', 'id');
    }

    public function catalogPropertyValues(): HasMany
    {
        return $this->hasMany(CatalogPropertyValue::class, 'catalog_property_unit_id', 'id');
    }
}
