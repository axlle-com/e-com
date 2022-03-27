<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%wallet_transaction_type}}".
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
class WalletTransactionType extends BaseModel
{
    protected $table = 'ax_wallet_transaction_type';
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
        return $this->hasMany(WalletTransaction::class, 'transaction_type_id', 'id');
    }

    public static function find(array $data): WalletTransactionType
    {
        /* @var $model WalletTransactionType */
        if (!empty($data['type'])) {
            $model = self::query()
                ->where('name', $data['type'])
                ->first();
            if ($model) {
                return $model;
            }
        }
        return self::sendError(['transaction_type_id' => 'Not found']);
    }

    public static function getTypeRule(): string
    {
        $items = self::query()->pluck('name')->toArray();
        $rule = 'in:';
        foreach ($items as $item) {
            $rule .= $item . ',';
        }
        return trim($rule, ',');
    }
}
