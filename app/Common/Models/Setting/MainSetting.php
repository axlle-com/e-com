<?php

namespace App\Common\Models\Setting;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\History\HasHistory;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property string $key
 * @property string|null $title
 * @property string|null $description
 * @property string|null $value_string
 * @property string|null $value_text
 * @property string|null $value_json
 * @property string|null $value_bool
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class MainSetting extends BaseModel
{
    use HasHistory;

    protected $table = 'ax_main_setting';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }
}
