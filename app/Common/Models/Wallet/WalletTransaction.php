<?php

namespace App\Common\Models\Wallet;

use App\Common\Components\Helper;
use App\Common\Models\Catalog\Document\CatalogDocument;
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
 * @property string $type
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
    private ?Wallet $_wallet = null;
    private ?WalletCurrency $_walletCurrency = null;
    private ?float $_ratio = null;
    protected $table = 'ax_wallet_transaction';
    private int $transaction_subject_id;
    private mixed $transaction_type_id;

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'wallet_id' => 'Wallet ID',
            'wallet_currency_id' => 'Wallet Currency ID',
            'type' => 'Transaction Type ID',
            'wallet_transaction_subject_id' => 'Transaction Subject ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [
                    'value' => 'required|numeric',
                    'currency' => 'required|string|' . WalletCurrency::getCurrencyNameRule(),
                    'subject' => 'required|string|' . WalletTransactionSubject::getSubjectRule(),
                    'type' => 'required|string|' . CatalogDocument::getTypeRule(),
                ],
            ][$type] ?? [];
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

    public function setWallet($data): void
    {
        if (isset($data['wallet_id']) || isset($data['wallet'])) {
            if (isset($data['wallet']) && $data['wallet'] instanceof Wallet) {
                $this->_wallet = $data['wallet'];
                $this->wallet_id = $data['wallet']->id;
            } elseif (isset($data['wallet_id'])) {
                /* @var $wallet Wallet */
                $wallet = Wallet::builder()->where('id', $data['wallet_id'])->first();
                if ($wallet) {
                    $this->_wallet = $wallet;
                    $this->wallet_id = $wallet->id;
                } else {
                    $this->setErrors(['wallet_id' => 'Not found']);
                }
            }
        } else {
            $this->setErrors(['wallet_id' => 'Not found']);
        }
    }

    public function setWalletCurrency($data): void
    {
        if (!empty($data['currency'])) {
            $this->_walletCurrency = WalletCurrency::getCurrencyByName($data['currency']);
            if (!$this->_walletCurrency) {
                $this->setErrors(['wallet_currency_id' => 'Not found']);
            } else {
                $this->wallet_currency_id = $this->_walletCurrency->id;
            }
        } else {
            $this->setErrors(['wallet_currency_id' => 'Not found']);
        }
    }

    public function setValue($data): void
    {
        if (!empty($data['value'])) {
            $this->value = $data['value'];
        } else {
            $this->setErrors(['value' => 'Not found']);
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
                if ($this->type === 'debit') {
                    if ($balance < $sum) {
                        $this->setErrors(['wallet' => 'Нет средств на счете']);
                    } else {
                        $balance -= $sum;
                        $this->_wallet->balance = Helper::balances($balance);
                    }
                } else {
                    $balance += $sum;
                    $this->_wallet->balance = Helper::balances($balance);
                }
            } else {
                $this->setErrors(['wallet' => 'Not found wallet or not found wallet currency  or not found transaction type']);
            }
        } else {
            $this->setErrors(['value' => 'Not found']);
        }
    }

    public function clearWallet(): void
    {
        unset($this->_wallet->wallet_currency_name, $this->_wallet->wallet_currency_title, $this->_wallet->wallet_currency_is_national);
    }

    public function setType($data): void
    {
        if (!empty($data['type'])) {
            $this->type = $data['type'];
        } else {
            $this->setErrors(['type' => 'Not found']);
        }
    }

    public function setSubject($data): void
    {
        if (!empty($data['subject']) && $subject = WalletTransactionSubject::find($data)) {
            if ($error = $subject->getErrors()) {
                $this->setErrors($error);
            } else {
                $this->transaction_subject_id = $subject->id;
            }
        } else {
            $this->setErrors(['transaction_subject_id' => 'Not found']);
        }
    }

    public function getFields(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->transaction_type_id,
            'subject' => $this->transaction_subject_id,
            'currency' => $this->wallet_currency_id,
            'value' => $this->value,
        ];
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
        ########### type TODO: закешировать
        $model->setType($data);
        ########### subject TODO: закешировать
        $model->setSubject($data);
        ########### save Wallet balance
        $model->setValueWallet($data);
        $model->clearWallet();
        ########### save
        DB::beginTransaction();
        if (!$model->safe()->getErrors() && $model->_wallet->save()) {
            DB::commit();
            return $model;
        }
        DB::rollBack();
        return $model->setErrors();
    }
}
