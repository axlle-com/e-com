<?php

namespace App\Common\Models\User;

use App\Common\Models\Errors\Errors;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Password;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $email
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class BaseUser extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasFactory, Notifiable, Password, HasRoles, Errors, HasHistory;
}
