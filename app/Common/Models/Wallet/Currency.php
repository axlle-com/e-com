<?php

namespace App\Common\Models\Wallet;

use SimpleXMLElement;
use Illuminate\Support\Facades\DB;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Common\Models\Catalog\CatalogBasket;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Product\CatalogProductHasCurrency;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property int $id
 * @property string $global_id
 * @property int $num_code
 * @property string $char_code
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocument[] $catalogDocuments
 * @property CatalogProductHasCurrency[] $catalogProductHasCurrencies
 * @property CatalogProduct[] $catalogProducts
 * @property CurrencyExchangeRate[] $currencyExchangeRates
 * @property WalletCurrency[] $walletCurrencies
 */
class Currency extends BaseModel
{
    public const RUB = 810;

    protected $table = 'ax_currency';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
                'show_rate' => [
//                    'sum' => 'required|numeric',
                    'currency' => 'required|array',
                    'currency.*' => 'required|numeric',
                ],
            ][$type] ?? [];
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
        $currencyModel = self::query()
            ->join(CurrencyExchangeRate::table(), CurrencyExchangeRate::table('currency_id'), '=', self::table('id'))
            ->where('char_code', 'USD')
            ->first();
        return (bool)$currencyModel;
    }

    public static function showRateCurrency(array $data): Model
    {
        $select = '';
        foreach ($data['currency'] as $currency) {
            $select .= "rate_" . $currency . ".value as '__" . $currency . "',";
        }
        $select = trim($select, ',');
        $currencyModel = self::query()->selectRaw($select);
        foreach ($data['currency'] as $currency) {
            $subQuery0 = DB::raw("(select ax_currency.id from ax_currency where ax_currency.num_code=" . $currency . " )");
            $subQuery1 = DB::raw("(select rate.id from ax_currency_exchange_rate as rate where rate.currency_id=" . $subQuery0 . " order by rate.date_rate desc limit 1)");
            $currencyModel->leftJoin('ax_currency_exchange_rate as rate_' . $currency, 'rate_' . $currency . '.id', '=', $subQuery1);
        }
        return $currencyModel->first();
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

    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::class, ['currency_id' => 'id']);
    }

    public function getCatalogProductHasCurrencies()
    {
        return $this->hasMany(CatalogProductHasCurrency::class, ['currency_id' => 'id']);
    }

    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, ['id' => 'catalog_product_id'])->viaTable('{{%catalog_product_has_currency}}', ['currency_id' => 'id']);
    }

    public function currencyExchangeRates(): HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'currency_id', 'id');
    }

    public function walletCurrencies(): HasMany
    {
        return $this->hasMany(WalletCurrency::class, 'currency_id', 'id');
    }
}
