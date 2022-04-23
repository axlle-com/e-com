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
    protected $table = 'ax_fin_transaction_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
