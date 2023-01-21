<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SimpleXMLElement;

/**
 * This is the model class for table "{{%currency_exchange_rate}}".
 *
 * @property string $id
 * @property string $currency_id
 * @property float $value
 * @property int $date_rate
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Currency $currency
 */
class CurrencyExchangeRate extends BaseModel
{
    protected $table = 'ax_currency_exchange_rate';

    public static function rules(string $type = 'default'): array
    {
        return ['default' => [],][$type] ?? [];
    }

    public static function _create(SimpleXMLElement $data): int
    {
        $cnt = 0;
        foreach ($data as $item) {
            if ($currency = Currency::existOrCreate($item)) {
                $date = strtotime($data['Date']);
                if (!self::query()->where('currency_id', $currency->id)->where('date_rate', $date)->first()) {
                    $model = new self();
                    $val = str_replace(',', '.', $item->Value);
                    $model->value = (float)$val;
                    $model->date_rate = $date;
                    $model->currency_id = $currency->id;
                    if ($model->save()) {
                        $cnt++;
                    }
                }
            }
        }
        return $cnt;
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'currency_id' => 'Currency ID',
            'value' => 'Value',
            'date_ rate' => 'Date Rate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
