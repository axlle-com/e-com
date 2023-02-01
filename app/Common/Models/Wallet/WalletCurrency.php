<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%wallet_currency}}".
 *
 * @property int $id
 * @property int $currency_id
 * @property string $name
 * @property string $title
 * @property int $is_national
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Wallet[] $wallets
 * @property Currency $currency
 * @property WalletTransaction[] $walletTransactions
 */
class WalletCurrency extends BaseModel
{
    protected $table = 'ax_wallet_currency';

    public static function rules(string $type = 'default'): array
    {
        return ['default' => [],][$type] ?? [];
    }

    public static function getCurrencyByName(string $name): ?WalletCurrency
    {
        /** @var  $model WalletCurrency */
        return ($model = self::query()->where('name', $name)->first()) ? $model : null;
    }

    public static function getCurrencyNameRule(): string
    {
        $items = self::query()->pluck('name')->toArray();
        $rule = 'in:';
        foreach ($items as $item) {
            $rule .= $item . ',';
        }
        return trim($rule, ',');
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'currency_id' => 'Currency ID',
            'name' => 'Name',
            'title' => 'Title',
            'is_national' => 'Is National',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class, 'wallet_currency_id', 'id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function getWalletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, ['wallet_currency_id' => 'id']);
    }

    public function ratio(string $currency): ?float
    {
        if ($currency === $this->name) {
            return 1;
        }
        function getRate(string $currency)
        {
            return CurrencyExchangeRate::query()
                                       ->join('ax_currency', 'ax_currency.id', '=', 'ax_currency_exchange_rate.currency_id')
                                       ->where('ax_currency.char_code', $currency)
                                       ->where('date_rate', '<=', time())
                                       ->first();
        }

        /** @var  $rate CurrencyExchangeRate */
        if ($this->is_national) {
            $rate = getRate($currency);
            return isset($rate) ? $rate->value : null;
        }
        $rate = getRate($this->name);
        return isset($rate) ? 1 / $rate->value : null;
    }
}
