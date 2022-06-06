<?php

namespace App\Common\Models\User;

use App\Common\Components\Sms\SMSRU;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Password;

/**
 * This is the model class for table "{{%user_guest}}".
 *
 * @property int $id
 * @property string $email
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class UserGuest extends BaseModel
{
    use Password;

    protected $table = 'ax_user_guest';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function sendCodePassword(array $post): bool
    {
        $ids = session('auth_key_guest', []);
        if (
            $ids
            && !empty($ids['code'])
            && !empty($ids['phone'])
            && !empty($ids['expired_at'])
            && $ids['expired_at'] > time()
        ) {
            return true;
        }
        $pass = $this->generatePassword();
        $data = new \stdClass();
        $data->to = '+7' . _clear_phone($post['phone']);
        $data->msg = $pass;
        $sms = (new SMSRU())->sendOne($data);
        if ($sms->status === "OK") {
            session(['auth_key_guest' => [
                'code' => $pass,
                'phone' => _clear_phone($post['phone']),
                'expired_at' => time() + (60 * 15),
            ]]);
            return true;
        }
        return false;
    }

    public function validateCode(array $post): bool
    {
        $ids = session('auth_key_guest', []);
        $if = $ids
            && !empty($ids['code'])
            && !empty($ids['expired_at'])
            && ($ids['expired_at'] > time())
            && ($ids['code'] == $post['code']);
        if ($if){
            session(['auth_key_guest' => []]);
            session(['_user_guest' => [
                'phone' => $ids['phone'],
            ]]);
            return true;
        }
        return false;
    }
}
