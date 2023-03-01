<?php

namespace App\Common\Models\User;

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
class UserService extends UserBaseService
{
    public string $sessionKeyCode = 'auth_key_user';
    public string $sessionKey = '_user';
}
