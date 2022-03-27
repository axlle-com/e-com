<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SimpleXMLElement;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property string $id
 * @property string $title
 * @property int $num_code
 * @property string $char_code
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CurrencyExchangeRate[] $currencyExchangeRates
 * @property WalletCurrency[] $walletCurrencies
 */
class Currency extends BaseModel
{
    protected $table = 'ax_currency';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'num_code' => 'Num Code',
            'char_code' => 'Char Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
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
        if ($id = $data['ID'] ?? null) {
            if ($model = self::query()->where('id', $id)->first()) {
                return $model;
            }
            $model = new self();
            $model->id = (string)$id;
            $model->num_code = (string)$data->NumCode;
            $model->char_code = (string)$data->CharCode;
            $model->title = (string)$data->Name;
            return $model->save() ? $model : null;
        }
        return null;
    }
}
