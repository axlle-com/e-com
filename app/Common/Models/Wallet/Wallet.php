<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%wallet}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $wallet_currency_id
 * @property float|null $balance
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property User $user
 * @property WalletCurrency $walletCurrency
 * @property WalletTransaction[] $walletTransactions
 */
class Wallet extends BaseModel
{
    private ?WalletCurrency $_walletCurrency = null;
    protected $table = 'ax_wallet';
    private int $wallet_currency_is_national;
    private string $wallet_currency_title;
    private string $wallet_currency_name;

    public static function rules(string $type = 'set'): array
    {
        return [
                'set' => [
                    'currency' => 'required|string|' . WalletCurrency::getCurrencyNameRule(),
                    'deposit' => 'required|numeric',
                ],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'wallet_currency_id' => 'Currency ID',
            'balance' => 'Balance',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function walletCurrency(): BelongsTo
    {
        return $this->belongsTo(WalletCurrency::class, 'wallet_currency_id', 'id');
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id', 'id');
    }

    public function getFields(): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->fields(),
            'currency' => $this->walletCurrency->title, # TODO: закешировать результат ниже line->109
            'balance' => $this->balance,
        ];
    }

    public function getBalance(): float
    {
        return round($this->balance, 2);
    }

    public function setBalance(array $data): void
    {
        $this->balance = 0.0;
    }

    public function setCurrency(array $data): void
    {
        $walletCurrency = WalletCurrency::getCurrencyByName($data['currency']);
        if (!$walletCurrency) {
            $this->setErrors(_Errors::error(['wallet_currency_id' => 'Not found'], $this));
        } else {
            # кешируем валюту
            $this->_walletCurrency = $walletCurrency;
            $this->wallet_currency_id = $walletCurrency->id;
        }
    }

    # кешируем валюту
    public function setWalletCurrency(): void
    {
        $this->wallet_currency_name = $this->_walletCurrency->name;
        $this->wallet_currency_title = $this->_walletCurrency->title;
        $this->wallet_currency_is_national = $this->_walletCurrency->is_national;
    }

    public function setUser(array $data): void
    {
        if ($data['user_id']) {
            $this->user_id = $data['user_id'];
        } else {
            $this->setErrors(_Errors::error(['user_id' => 'Not found'], $this));
        }
    }

    public static function create(array $data): Wallet
    {
        if (self::query()->where('user_id', $data['user_id'])->first()) {
            return self::sendErrors(['user_id' => 'У пользователя уже есть кошелек']);
        }
        DB::beginTransaction();
        $model = new self();
        ########### wallet_currency
        $model->setCurrency($data);
        ########### user
        $model->setUser($data);
        ########### balance
        $model->setBalance($data);
        ########### save
        if (!$model->safe()->getErrors()) {
            ########### transaction
            $model->setWalletCurrency();
            $data = [
                'currency' => $data['currency'],
                'subject' => 'refund', # TODO: на время...
                'type' => 'credit',
                'value' => $data['deposit'],
                'wallet' => $model,
            ];
            $transaction = WalletTransaction::create($data);
            if ($error = $transaction->getErrors()) {
                DB::rollBack();
                return $model->setErrors($error);
            }
            DB::commit();
            return $model;
        }
        DB::rollBack();
        return $model;
    }

    public static function find(array $data): Wallet
    {
        /* @var $model Wallet */
        $model = self::query()
            ->with(['user', 'walletCurrency'])
            ->where('user_id', $data['user_id'])
            ->first();
        if ($model) {
            return $model;
        }
        return self::sendErrors(['user_id' => 'У пользователя нет кошелька']);
    }

    public static function builder(): Builder
    {
        return self::query()
            ->select([
                'ax_wallet.*',
                'wc.name as wallet_currency_name',
                'wc.title as wallet_currency_title',
                'wc.is_national as wallet_currency_is_national',
            ])
            ->join('ax_wallet_currency as wc', 'wc.id', '=', 'ax_wallet.wallet_currency_id');
    }
}
