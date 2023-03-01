<?php

namespace App\Common\Models\User;

use App\Common\Components\Sms\SMSRU;
use App\Common\Models\Main\BaseService;
use stdClass;

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
class UserBaseService extends BaseService
{
    public string $sessionKeyCode = 'auth_key_user';
    public string $sessionKey = '_user';
    protected BaseUser $user;

    public function __construct(BaseUser $user)
    {
        $this->user = $user;
    }

    protected function checkUserSessionCode(): bool
    {
        $ids = session($this->sessionKeyCode, []);
        return $ids && !empty($ids['code']) && !empty($ids['phone']) && !empty($ids['expired_at']) && $ids['expired_at'] > time();
    }

    public function sendCodePassword(array $post): bool
    {
        if($this->checkUserSessionCode()) {
            return true;
        }
        $pass = $this->user->generatePassword();
        $data = new stdClass();
        $data->to = '+7' . _clear_phone($post['phone']);
        $data->msg = $pass;
        $sms = (new SMSRU())->sendOne($data);
        if($sms->status === "OK") {
            session([
                $this->sessionKeyCode => [
                    'user' => $this->user->toArray(),
                    'code' => $pass,
                    'phone' => _clear_phone($post['phone']),
                    'expired_at' => time() + (60 * 15),
                ],
            ]);
            return true;
        }
        return false;
    }

    public function validateCode(array $post): bool
    {
        $ids = session($this->sessionKeyCode, []);
        $if = $this->checkUserSessionCode() && ($ids['code'] === (string)$post['code']);
        if($if) {
            session([$this->sessionKeyCode => []]);
            session([$this->sessionKey => $this->user->toArray()]);
            return true;
        }
        return false;
    }
}
