<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_fin_transaction_type".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class FinTransactionType extends BaseModel
{
    public static ?self $_credit;
    public static ?self $_debit;

    protected $table = 'ax_fin_transaction_type';

    public static function credit(): self
    {
        if (empty(self::$_credit)) {
            /* @var $self self */
            $self = self::query()->where('name', 'credit')->first();
            self::$_credit = $self;
        }
        return self::$_credit;
    }

    public static function debit(): self
    {
        if (empty(self::$_debit)) {
            /* @var $self self */
            $self = self::query()->where('name', 'debit')->first();
            self::$_debit = $self;
        }
        return self::$_debit;
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
