<?php

namespace App\Common\Models;

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
    public const DEBET = 1;
    public const CREDIT = 2;

    public static ?self $credit;
    public static ?self $debet;

    private static array $type = [
        self::DEBET => 'debet',
        self::CREDIT => 'credit',
    ];
    protected $table = 'ax_fin_transaction_type';

    public static function credit(): self
    {
        if (empty(self::$credit)) {
            self::$credit = (new self())->setId(self::CREDIT);
        }
        return self::$credit;
    }

    public static function debit(): self
    {
        if (empty(self::$debet)) {
            self::$debet = (new self())->setId(self::DEBET);
        }
        return self::$debet;
    }

    public static function getSubjectRule(): string
    {
        $items = array_keys(self::$type);
        $rule = 'in:';
        foreach ($items as $item) {
            $rule .= $item . ',';
        }
        return trim($rule, ',');
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}
