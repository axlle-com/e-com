<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property int $id
 * @property string $global_id
 * @property string $num_code
 * @property string $char_code
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogProductHasCurrency[] $catalogProductHasCurrencies
 * @property CatalogProduct[] $catalogProducts
 * @property CurrencyExchangeRate[] $currencyExchangeRates
 */
class Currency extends BaseModel
{
    protected $table = 'ax_currency';

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
            'global_id' => 'Global ID',
            'num_code' => 'Num Code',
            'char_code' => 'Char Code',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['currency_id' => 'id']);
    }

    public function getCatalogProductHasCurrencies()
    {
        return $this->hasMany(CatalogProductHasCurrency::class, ['currency_id' => 'id']);
    }

    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, ['id' => 'catalog_product_id'])->viaTable('{{%catalog_product_has_currency}}', ['currency_id' => 'id']);
    }

    public function getCurrencyExchangeRates()
    {
        return $this->hasMany(CurrencyExchangeRate::class, ['currency_id' => 'id']);
    }
}
