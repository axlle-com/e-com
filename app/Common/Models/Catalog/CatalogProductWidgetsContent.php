<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_product_widgets_content}}".
 *
 * @property int $id
 * @property int $catalog_product_widgets_id
 * @property string $title
 * @property string $title_short
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $show_image
 * @property string|null $media
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProductWidgets $catalogProductWidgets
 */
class CatalogProductWidgetsContent extends BaseModel
{
    protected $table = 'ax_catalog_product_widgets_content';

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
            'catalog_product_widgets_id' => 'Catalog Product Widgets ID',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'image' => 'Image',
            'sort' => 'Sort',
            'show_image' => 'Show Image',
            'media' => 'Media',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogProductWidgets()
    {
        return $this->hasOne(CatalogProductWidgets::className(), ['id' => 'catalog_product_widgets_id']);
    }
}
