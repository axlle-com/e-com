<?php

namespace App\Common\Models\Wallet;

use App\Common\Components\Helper;
use App\Common\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%wallet_transaction}}".
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $wallet_currency_id
 * @property int $transaction_type_id
 * @property int $transaction_reason_id
 * @property float $value
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Wallet $wallet
 * @property Wallet $_wallet
 * @property WalletCurrency $_walletCurrency
 * @property WalletCurrency $walletCurrency
 * @property WalletTransactionReason $transactionReason
 * @property WalletTransactionType $transactionType
 * @property WalletTransactionType $_transactionType
 */
class WalletTransaction extends BaseModel
{
    private ?Wallet $_wallet = null;
    private ?WalletCurrency $_walletCurrency = null;
    private ?WalletTransactionType $_transactionType = null;
    private ?float $_ratio = null;
    protected $table = 'ax_wallet_transaction';
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'wallet_id' => 'Wallet ID',
            'wallet_currency_id' => 'Wallet Currency ID',
            'transaction_type_id' => 'Transaction Type ID',
            'transaction_reason_id' => 'Transaction Reason ID',
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
                    'reason' => 'required|string|' . WalletTransactionReason::getReasonRule(),
                    'type' => 'required|string|' . WalletTransactionType::getTypeRule(),
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

    public function transactionReason(): BelongsTo
    {
        return $this->belongsTo(WalletTransactionReason::class, 'transaction_reason_id', 'id');
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(WalletTransactionType::class, 'transaction_type_id', 'id');
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
                    $this->setError(['wallet_id' => 'Not found']);
                }
            }
        } else {
            $this->setError(['wallet_id' => 'Not found']);
        }
    }

    public function setWalletCurrency($data): void
    {
        if (!empty($data['currency'])) {
            $this->_walletCurrency = WalletCurrency::getCurrencyByName($data['currency']);
            if (!$this->_walletCurrency) {
                $this->setError(['wallet_currency_id' => 'Not found']);
            } else {
                $this->wallet_currency_id = $this->_walletCurrency->id;
            }
        } else {
            $this->setError(['wallet_currency_id' => 'Not found']);
        }
    }

    public function setValue($data): void
    {
        if (!empty($data['value'])) {
            $this->value = $data['value'];
        } else {
            $this->setError(['value' => 'Not found']);
        }
    }

    public function setValueWallet($data): void
    {
        if (!empty($data['value'])) {
            # если есть кошелек и есть валюта кошелька и найден тип транзакции
            if ($this->_wallet && $this->_walletCurrency && $this->_transactionType) {
                $balance = $this->_wallet->balance;
                $sum = $data['value'] * $this->_wallet->walletCurrency->ratio($this->_walletCurrency->name);
                # debit происходит списание со счета
                if ($this->_transactionType->name === 'debit') {
                    if ($balance < $sum) {
                        $this->setError(['wallet' => 'Нет средств на счете']);
                    } else {
                        $balance -= $sum;
                        $this->_wallet->balance = Helper::balances($balance);
                    }
                } else {
                    $balance += $sum;
                    $this->_wallet->balance = Helper::balances($balance);
                }
            } else {
                $this->setError(['wallet' => 'Not found wallet or not found wallet currency  or not found transaction type']);
            }
        } else {
            $this->setError(['value' => 'Not found']);
        }
    }

    public function clearWallet(): void
    {
        unset($this->_wallet->wallet_currency_name, $this->_wallet->wallet_currency_title, $this->_wallet->wallet_currency_is_national);
    }

    public function setType($data): void
    {
        if (!empty($data['type']) && $type = WalletTransactionType::find($data)) {
            if ($error = $type->getError()) {
                $this->setError($error);
            } else {
                $this->transaction_type_id = $type->id;
                $this->_transactionType = $type;
            }
        } else {
            $this->setError(['transaction_type_id' => 'Not found']);
        }
    }

    public function setReason($data): void
    {
        if (!empty($data['reason']) && $reason = WalletTransactionReason::find($data)) {
            if ($error = $reason->getError()) {
                $this->setError($error);
            } else {
                $this->transaction_reason_id = $reason->id;
            }
        } else {
            $this->setError(['transaction_reason_id' => 'Not found']);
        }
    }

    public function getFields(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->transaction_type_id,
            'reason' => $this->transaction_reason_id,
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
        ########### reason TODO: закешировать
        $model->setReason($data);
        ########### save Wallet balance
        $model->setValueWallet($data);
        $model->clearWallet();
        ########### save

        DB::beginTransaction();
        try {
            $result = !$model->getError() && $model->save() && $model->_wallet->save();
        } catch (Exception $exception) {
            $error = $exception->getMessage();
            $model->setError([$error]);
        }
        if ($result ?? null) {
            DB::commit();
            return $model;
        }
        DB::rollBack();
        return $model->setError();
    }
}
