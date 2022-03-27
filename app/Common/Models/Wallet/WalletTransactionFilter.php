<?php

namespace App\Common\Models\Wallet;

use App\Common\Components\QueryFilter;
use Illuminate\Support\Facades\DB;

/**
 * @property int $transaction_id
 * @property float $transaction_value
 * @property float $wallet_balance
 * @property string $user_email
 * @property string $currency_name
 * @property string $currency_title
 * @property int|null $currency_is_national
 * @property string $reason_name
 * @property string $reason_title
 * @property string $type_name
 * @property string $type_title
 *
 */
class WalletTransactionFilter extends QueryFilter
{
    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [
                    'transaction_id' => 'nullable|integer',
                    'transaction_value' => 'nullable|numeric',
                    'wallet_id' => 'nullable|integer',
                    'currency_id' => 'nullable|integer',
                    'currency_name' => 'nullable|string|' . WalletCurrency::getCurrencyNameRule(),
                    'currency_title' => 'nullable|string',
                    'reason_id' => 'nullable|integer',
                    'reason_name' => 'nullable|string|' . WalletTransactionReason::getReasonRule(),
                    'reason_title' => 'nullable|string',
                    'type_id' => 'nullable|integer',
                    'type_name' => 'nullable|string|' . WalletTransactionType::getTypeRule(),
                    'type_title' => 'nullable|string',
                ],
            ][$type] ?? [];
    }

    public static function builder(array $post = []): WalletTransactionFilter
    {
        $transaction = DB::table('ax_wallet_transaction as transaction')
            ->select([
                'user.email as user_email',
                'transaction.id as transaction_id',
                'transaction.value as transaction_value',
                'currency.name as currency_name',
                'currency.title as currency_title',
                'currency.is_national as currency_is_national',
                'reason.name as reason_name',
                'reason.title as reason_title',
                'type.name as type_name',
                'type.title as type_title',
            ])
            ->join('ax_wallet as wallet', 'wallet.id', '=', 'transaction.wallet_id')
            ->join('ax_user as user', 'user.id', '=', 'wallet.user_id')
            ->join('ax_wallet_currency as currency', 'currency.id', '=', 'transaction.wallet_currency_id')
            ->join('ax_wallet_transaction_reason as reason', 'reason.id', '=', 'transaction.transaction_reason_id')
            ->join('ax_wallet_transaction_type as type', 'type.id', '=', 'transaction.transaction_type_id');
        return (new self($post))->setBuilder($transaction);
    }

    public function transaction_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('transaction.id', $value);
    }

    public function transaction_value(?float $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('transaction.value', $value);
    }

    public function wallet_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('wallet.id', $value);
    }

    public function currency_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('currency.id', $value);
    }

    public function currency_name(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('currency.name', $value);
    }

    public function currency_title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('currency.title', $value);
    }

    public function reason_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('reason.id', $value);
    }

    public function reason_name(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('reason.name', $value);
    }

    public function reason_title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('reason.title', $value);
    }

    public function type_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('type.id', $value);
    }

    public function type_name(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('type.name', $value);
    }

    public function type_title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('type.title', $value);
    }
}
