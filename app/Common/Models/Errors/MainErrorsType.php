<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_main_errors_type}}".
 *
 * @property int $id
 * @property int $errors_type_id
 * @property int|null $user_id
 * @property int|null $ips_id
 * @property string|null $message
 * @property string|null $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class MainErrorsType extends BaseModel
{
    protected $table = 'ax_main_errors_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }
}
