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
class UserGuest extends User
{
    protected $table = 'ax_user_guest';
    protected $fillable = [
        'email',
        'name',
    ];

    public static function createOrUpdate(array $post): static
    {
        /** @var static $model */
        if (empty($post['email']) || !$user = static::findAnyLogin($post)) {
            return static::create($post);
        }
        return $user->loadModel($post)->safe();
    }
}
