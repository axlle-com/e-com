<?php

namespace App\Common\Models;

use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\UserSetter;

/**
 * This is the model class for table "{{%settings}}".
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
class Settings extends Main\BaseModel
{
    use EventSetter, UserSetter;

    protected $table = 'ax_settings';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'script' => 'Script',
            'css' => 'Css',
            'robots' => 'Robots',
            'google_verification' => 'Google Verification',
            'yandex_verification' => 'Yandex Verification',
            'yandex_metrika' => 'Yandex Metrika',
            'google_analytics' => 'Google Analytics',
            'logo_general' => 'Logo General',
            'logo_second' => 'Logo Second',
            'company_name' => 'Company Name',
            'company_name_full' => 'Company Name Full',
            'company_phone' => 'Company Phone',
            'company_email' => 'Company Email',
            'company_address' => 'Company Address',
            'redirect_on' => 'Redirect On',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
