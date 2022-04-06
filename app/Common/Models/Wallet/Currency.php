<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\BaseModel;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\CatalogProductHasCurrency;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

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


    public function currencyExchangeRates(): HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'currency_id', 'id');
    }

    public function walletCurrencies(): HasMany
    {
        return $this->hasMany(WalletCurrency::class, 'currency_id', 'id');
    }

    public static function existOrCreate(SimpleXMLElement $data): ?self
    {
        /* @var $model self */
        if ($global_id = $data['ID'] ?? null) {
            if ($model = self::query()->where('global_id', $global_id)->first()) {
                return $model;
            }
            $model = new self();
            $model->global_id = (string)$global_id;
            $model->num_code = (string)$data->NumCode;
            $model->char_code = (string)$data->CharCode;
            $model->title = (string)$data->Name;
            return $model->save() ? $model : null;
        }
        return null;
    }

    public static function checkExistRate(): bool
    {
        $currency = 'USD';
        $subQuery = DB::raw("(select ax_wallet_currency.currency_id from ax_wallet_currency where ax_wallet_currency.name='$currency' limit 1)");
        $currencyModel = self::query()
            ->join('ax_currency_exchange_rate as rate', 'rate.currency_id', '=', $subQuery)
            ->where('char_code', $currency)
            ->first();
        return (bool)$currencyModel;
    }
}
