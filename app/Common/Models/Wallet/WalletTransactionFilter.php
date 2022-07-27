<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Main\QueryFilter;

/**
 * @property int $transaction_id
 * @property float $transaction_value
 * @property float $wallet_balance
 * @property string $user_email
 * @property string $currency_name
 * @property string $currency_title
 * @property int|null $currency_is_national
 * @property string $subject_name
 * @property string $subject_title
 * @property string $type_name
 * @property string $type_title
 *
 */
class WalletTransactionFilter extends QueryFilter
{
    public static function rules(string $type = 'create'): array
    {
        return [
                'default' => [
                    'transaction_id' => 'nullable|integer',
                    'transaction_value' => 'nullable|numeric',
                    'wallet_id' => 'nullable|integer',
                    'currency_id' => 'nullable|integer',
                    'currency_name' => 'nullable|string|' . WalletCurrency::getCurrencyNameRule(),
                    'currency_title' => 'nullable|string',
                    'subject_id' => 'nullable|integer',
                    'subject_name' => 'nullable|string|' . WalletTransactionSubject::getSubjectRule(),
                    'subject_title' => 'nullable|string',
                    'type_id' => 'nullable|integer',
                    'type_name' => 'nullable|string|' . CatalogDocument::getTypeRule(),
                    'type_title' => 'nullable|string',
                ],
            ][$type] ?? [];
    }

    public static function builder(array $post = []): WalletTransactionFilter
    {
        $transaction = WalletTransaction::query()
            ->select([
                WalletTransaction::table('id') . ' as transaction_id',
                WalletTransaction::table('value') . ' as transaction_value',
                'user.email as user_email',
                'currency.name as currency_name',
                'currency.title as currency_title',
                'currency.is_national as currency_is_national',
                'subject.name as subject_name',
                'subject.title as subject_title',
                'type.name as type_name',
                'type.title as type_title',
            ])
            ->join('ax_wallet as wallet', 'wallet.id', '=', WalletTransaction::table('wallet_id'))
            ->join('ax_user as user', 'user.id', '=', 'wallet.user_id')
            ->join('ax_wallet_currency as currency', 'currency.id', '=', WalletTransaction::table('wallet_currency_id'))
            ->join('ax_wallet_transaction_subject as subject', 'subject.id', '=', WalletTransaction::table('wallet_transaction_subject_id'))
            ->join('ax_fin_transaction_type as type', 'type.id', '=', 'subject.fin_transaction_type_id');
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

    public function subject_id(?int $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('subject.id', $value);
    }

    public function subject_name(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('subject.name', $value);
    }

    public function subject_title(?string $value): void
    {
        if (!$value) {
            return;
        }
        $this->builder->where('subject.title', $value);
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
