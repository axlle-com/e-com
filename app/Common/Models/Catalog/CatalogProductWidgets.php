<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_product_widgets}}".
 *
 * @property int $id
 * @property int $catalog_product_id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $catalogProduct
 * @property CatalogProductWidgetsContent[] $catalogProductWidgetsContents
 */
class CatalogProductWidgets extends BaseModel
{
    protected $table = 'ax_catalog_product_widgets';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_product_id' => 'Catalog Product ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::className(), ['id' => 'catalog_product_id']);
    }

    public function getCatalogProductWidgetsContents()
    {
        return $this->hasMany(CatalogProductWidgetsContent::className(), ['catalog_product_widgets_id' => 'id']);
    }
}
