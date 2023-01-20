<?php

namespace App\Common\Models\Wallet;

use App\Common\Components\Helper;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%wallet_transaction}}".
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $wallet_currency_id
 * @property int $wallet_transaction_subject_id
 * @property float|null $value
 * @property string|null $resource
 * @property int|null $resource_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Wallet $wallet
 * @property WalletCurrency $walletCurrency
 * @property WalletTransactionSubject $walletTransactionSubject
 */
class WalletTransaction extends BaseModel
{
    protected $table = 'ax_wallet_transaction';
    private ?Wallet $_wallet = null;
    private ?WalletCurrency $_walletCurrency = null;
    private ?float $_ratio = null;

    public static function rules(string $type = 'default'): array
    {
        return [
            'default' => [
                'value' => 'required|numeric',
                'currency' => 'required|string|' . WalletCurrency::getCurrencyNameRule(),
                'subject' => 'required|string|' . WalletTransactionSubject::getSubjectRule(),
            ],
        ][$type] ?? [];
    }

    public static function create(array $data): WalletTransaction
    {
        $model = new self();
        ########### wallet
        $model->setWallet($data);
        ########### currency
        $model->setWalletCurrency($data);
        ########### value
        $model->setValue($data);
        ########### subject TODO: закешировать
        $model->setSubject($data);
        ########### save Wallet balance
        $model->setValueWallet($data);
        $model->clearWallet();
        ########### save
        DB::beginTransaction();
        if (!($err = $model->safe()->getErrors()) && $model->_wallet->save()) {
            DB::commit();
            return $model;
        }
        DB::rollBack();
        return $model->setErrors($err);
    }

    public function setWallet($data): void
    {
        if (isset($data['wallet_id']) || isset($data['wallet'])) {
            if (isset($data['wallet']) && $data['wallet'] instanceof Wallet) {
                $this->_wallet = $data['wallet'];
                $this->wallet_id = $data['wallet']->id;
            } else if (isset($data['wallet_id'])) {
                /* @var $wallet Wallet */
                $wallet = Wallet::builder()->where('id', $data['wallet_id'])->first();
                if ($wallet) {
                    $this->_wallet = $wallet;
                    $this->wallet_id = $wallet->id;
                } else {
                    $this->setErrors(_Errors::error(['wallet_id' => 'Not found'], $this));
                }
            }
        } else {
            $this->setErrors(_Errors::error(['wallet_id' => 'Not found'], $this));
        }
    }

    public function setWalletCurrency($data): void
    {
        if (!empty($data['currency'])) {
            $this->_walletCurrency = WalletCurrency::getCurrencyByName($data['currency']);
            if (!$this->_walletCurrency) {
                $this->setErrors(_Errors::error(['wallet_currency_id' => 'Not found'], $this));
            } else {
                $this->wallet_currency_id = $this->_walletCurrency->id;
            }
        } else {
            $this->setErrors(_Errors::error(['wallet_currency_id' => 'Not found'], $this));
        }
    }

    public function setValue($data): void
    {
        if (!empty($data['value'])) {
            $this->value = $data['value'];
        } else {
            $this->setErrors(_Errors::error(['value' => 'Not found'], $this));
        }
    }

    public function setSubject($data): void
    {
        if (!empty($data['subject']) && $subject = WalletTransactionSubject::find($data)) {
            if ($error = $subject->getErrors()) {
                $this->setErrors($error);
            } else {
                $this->wallet_transaction_subject_id = $subject->id;
            }
        } else {
            $this->setErrors(_Errors::error(['transaction_subject_id' => 'Not found'], $this));
        }
    }

    public function setValueWallet($data): void
    {
        if (!empty($data['value'])) {
            # если есть кошелек и есть валюта кошелька
            if ($this->_wallet && $this->_walletCurrency) {
                $balance = $this->_wallet->balance;
                $sum = $data['value'] * $this->_wallet->walletCurrency->ratio($this->_walletCurrency->name);
                # debit происходит списание со счета
                if (in_array($data['subject'], [
                    'transfer',
                    'stock',
                ])) {
                    if ($balance < $sum) {
                        $this->setErrors(_Errors::error(['wallet' => 'Нет средств на счете'], $this));
                    } else {
                        $balance -= $sum;
                        $this->_wallet->balance = Helper::balances($balance);
                    }
                } else {
                    $balance += $sum;
                    $this->_wallet->balance = Helper::balances($balance);
                }
            } else {
                $this->setErrors(_Errors::error(['wallet' => 'Not found wallet or not found wallet currency  or not found transaction type'], $this));
            }
        } else {
            $this->setErrors(_Errors::error(['value' => 'Not found'], $this));
        }
    }

    public function clearWallet(): void
    {
        unset($this->_wallet->wallet_currency_name, $this->_wallet->wallet_currency_title, $this->_wallet->wallet_currency_is_national);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function walletCurrency(): BelongsTo
    {
        return $this->belongsTo(WalletCurrency::class, 'wallet_currency_id', 'id');
    }

    public function transactionSubject(): BelongsTo
    {
        return $this->belongsTo(WalletTransactionSubject::class, 'wallet_transaction_subject_id', 'id');
    }

    public function getFields(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->wallet_transaction_subject_id,
            'currency' => $this->wallet_currency_id,
            'value' => $this->value,
        ];
    }
}
