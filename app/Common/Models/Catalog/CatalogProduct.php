<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency;
use common\CatalogDocumentContent;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $render_id
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_comments
 * @property int|null $is_watermark
 * @property string|null $media
 * @property string $url
 * @property string $alias
 * @property string $title
 * @property float|null $price
 * @property string|null $title_short
 * @property string|null $preview_description
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $show_date
 * @property string|null $image
 * @property int|null $hits
 * @property int|null $sort
 * @property float|null $stars
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogCategory $category
 * @property Render $render
 * @property CatalogProductHasCurrency[] $catalogProductHasCurrencies
 * @property Currency[] $currencies
 */
class CatalogProduct extends BaseModel
{
    protected $table = 'ax_catalog_product';

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [],
        ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'render_id' => 'Render ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_comments' => 'Is Comments',
            'is_watermark' => 'Is Watermark',
            'media' => 'Media',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'price' => 'Price',
            'title_short' => 'Title Short',
            'preview_description' => 'Preview Description',
            'description' => 'Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'show_date' => 'Show Date',
            'image' => 'Image',
            'hits' => 'Hits',
            'sort' => 'Sort',
            'stars' => 'Stars',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['product_id' => 'id']);
    }

    public function getCatalogDocumentContents()
    {
        return $this->hasMany(CatalogDocumentContent::className(), ['catalog_product_id' => 'id']);
    }


    public function getCategory()
    {
        return $this->hasOne(CatalogCategory::class, ['id' => 'category_id']);
    }

    public function getRender()
    {
        return $this->hasOne(Render::class, ['id' => 'render_id']);
    }

    public function getCatalogProductHasCurrencies()
    {
        return $this->hasMany(CatalogProductHasCurrency::class, ['catalog_product_id' => 'id']);
    }

    public function getCurrencies()
    {
        return $this->hasMany(Currency::class, ['id' => 'currency_id'])->viaTable('{{%catalog_product_has_currency}}', ['catalog_product_id' => 'id']);
    }
}
