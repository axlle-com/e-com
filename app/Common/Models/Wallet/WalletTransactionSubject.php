<?php

namespace App\Common\Models\Wallet;

use App\Common\Models\Catalog\FinTransactionType;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "ax_wallet_transaction_subject".
 *
 * @property int $id
 * @property int $fin_transaction_type_id
 * @property string $name
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property WalletTransaction[] $walletTransactions
 * @property FinTransactionType $finTransactionType
 */
class WalletTransactionSubject extends BaseModel
{
    protected $table = 'ax_wallet_transaction_subject';

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

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'transaction_subject_id', 'id');
    }

    public function getFinTransactionType()
    {
        return $this->hasOne(FinTransactionType::className(), ['id' => 'fin_transaction_type_id']);
    }


    public static function find(array $data): WalletTransactionSubject
    {
        /* @var $model WalletTransactionSubject */
        if (!empty($data['subject'])) {
            $model = self::query()
                ->where('name', $data['subject'])
                ->first();
            if ($model) {
                return $model;
            }
        }
        return self::sendErrors(['transaction_subject_id' => 'Not found']);
    }

    public static function getSubjectRule(): string
    {
        $items = self::query()->pluck('name')->toArray();
        $rule = 'in:';
        foreach ($items as $item) {
            $rule .= $item . ',';
        }
        return trim($rule, ',');
    }
}
