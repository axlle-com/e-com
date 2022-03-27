<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%wallet_transaction_reason}}".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property WalletTransaction[] $walletTransactions
 */
class WalletTransactionReason extends BaseModel
{
    protected $table = 'ax_wallet_transaction_reason';
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
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'transaction_reason_id', 'id');
    }

    public static function find(array $data): WalletTransactionReason
    {
        /* @var $model WalletTransactionReason */
        if (!empty($data['reason'])) {
            $model = self::query()
                ->where('name', $data['reason'])
                ->first();
            if ($model) {
                return $model;
            }
        }
        return self::sendError(['transaction_reason_id' => 'Not found']);
    }

    public static function getReasonRule(): string
    {
        $items = self::query()->pluck('name')->toArray();
        $rule = 'in:';
        foreach ($items as $item) {
            $rule .= $item . ',';
        }
        return trim($rule, ',');
    }
}
