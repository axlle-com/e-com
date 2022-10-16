<?php

namespace App\Common\Models;

use App\Common\Models\Main\EventSetter;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property string|null $script
 * @property string|null $css
 * @property string|null $robots
 * @property string|null $google_verification
 * @property string|null $yandex_verification
 * @property string|null $yandex_metrika
 * @property string|null $google_analytics
 * @property string|null $logo_general
 * @property string|null $logo_second
 * @property string|null $company_name
 * @property string|null $company_name_full
 * @property string|null $company_phone
 * @property string|null $company_email
 * @property string|null $company_address
 * @property int|null $redirect_on
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class Setting extends Main\BaseModel
{
    use EventSetter;

    protected $table = 'ax_setting';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }
}
