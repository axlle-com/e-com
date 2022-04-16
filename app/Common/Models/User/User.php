<?php

namespace App\Common\Models\User;

use App\Common\Models\Blog\Post;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogDocument;
use App\Common\Models\Main\Password;
use App\Common\Models\Wallet\Wallet;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

/**
 * This is the model class for table "{{%ax_user}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $phone
 * @property string $email
 * @property string $password_hash
 * @property int $status
 * @property string|null $remember_token
 * @property string|null $auth_key
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property string|null $password
 * @property string|null $remember
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocument[] $catalogDocuments
 * @property Post[] $posts
 * @property UserToken[] $userTokens
 * @property Wallet[] $wallets
 *
 * @property UserToken|null $access_token
 * @property UserToken|null $refresh_access_token
 * @property UserToken|null $app_access_token
 * @property UserToken|null $app_refresh_access_token
 * @property UserToken|null $_access_token
 * @property UserToken|null $_refresh_access_token
 * @property UserToken|null $_app_access_token
 * @property UserToken|null $_app_refresh_access_token
 * @property-read UserToken|null $restToken
 * @property-read UserToken|null $restRefreshToken
 * @property-read UserToken|null $appToken
 * @property-read UserToken|null $appRefreshToken
 *
 * @property-read Wallet|null $wallet
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, Password, HasRoles;

    private static array $instances = [];
    private static array $authGuards = [
        UserRest::class => 'rest',
        UserApp::class => 'app',
        UserWeb::class => 'web',
    ];
    private static array $_authJwt = [];

    private array $errors = [];
    public ?UserToken $_access_token = null;
    public ?UserToken $_refresh_access_token = null;
    public ?UserToken $_app_access_token = null;
    public ?UserToken $_app_refresh_access_token = null;
    public $password = null;
    public $remember = null;
    protected string $guard_name = 'web';
    protected $table = 'ax_user';
    protected $dateFormat = 'U';
    protected $fillable = [
        'email',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function rules(string $type = 'login'): array
    {
        return [
                'login' => [
                    'email' => 'required|email',
                    'password' => 'required',
                ],
                'registration' => [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'email' => 'required|email',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6'
                ],
            ][$type] ?? [];
    }

    public static function authJwt(): ?object
    {
        return self::$_authJwt[static::class] ?? null;
    }

    public static function setAuthJwt(?string $authJwt): ?object
    {
        $data = UserToken::getJwt($authJwt);
        if ($data && $data->model) {
            $array = array_flip(self::$authGuards);
            self::$_authJwt[$array[$data->model]] = $data;
            return self::$_authJwt[$array[$data->model]];
        }
        return null;
    }

    public static function getTypeApp(string $model): ?string
    {
        return self::$authGuards[$model] ?? null;
    }

    public static function auth()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            if (UserWeb::class === $subclass) {
                self::$instances[$subclass] = Auth::user();
            } else {
                self::$instances[$subclass] = Auth::guard(self::$authGuards[$subclass])->user();
            }
        }
        return self::$instances[$subclass];
    }

    public static function validate(array $data): ?static
    {
        $login = $data['email'];
        $password = $data['password'];
        $remember = !empty($data['remember']);
        if ($login && ($user = static::findByLogin($login)) && Hash::check($password, $user->password_hash)) {
            $user->remember = $remember;
            return $user;
        }
        return null;
    }

    public function login()
    {
        if ($this instanceof UserWeb) {
            return Auth::loginUsingId($this->id, $this->remember);
        }
        if ($this instanceof UserApp) {
            return UserToken::createAppToken($this) && UserToken::createAppRefreshToken($this);
        }
        if ($this instanceof UserRest) {
            return UserToken::createRestToken($this) && UserToken::createRestRefreshToken($this);
        }
    }

    public static function findByLogin(string $email): ?User
    {
        /* @var $user static */
        $login = $email;
        if ($user = self::query()->where('email', $login)->first()) {
            return $user;
        }
        return null;
    }

    public function getAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_access_token) {
            $this->_access_token = $this->restToken;
        }
        return $this->_access_token;
    }

    public function getRefreshAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_refresh_access_token) {
            $this->_refresh_access_token = $this->restRefreshToken;
        }
        return $this->_refresh_access_token;
    }

    public function getAppAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_app_access_token) {
            $this->_app_access_token = $this->appToken;
        }
        return $this->_app_access_token;
    }

    public function getAppRefreshAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_app_refresh_access_token) {
            $this->_app_refresh_access_token = $this->appRefreshToken;
        }
        return $this->_app_refresh_access_token;
    }

    public function restToken(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id', $this->getKeyName())->where('type', UserToken::TYPE_REST_ACCESS);
    }

    public function restRefreshToken(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id', $this->getKeyName())->where('type', UserToken::TYPE_REST_REFRESH);
    }

    public function appToken(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id', $this->getKeyName())->where('type', UserToken::TYPE_APP_ACCESS);
    }

    public function appRefreshToken(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id', $this->getKeyName())->where('type', UserToken::TYPE_APP_REFRESH);
    }

    public function fields(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ];
    }

    public function setPassword(): bool
    {
        $this->password = $this->generatePassword();
        $this->password_hash = $this->generatePasswordHash($this->password);
        return $this->save();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $error): static
    {
        foreach ($error as $key => $value) {
            if (is_array($value)) {
                foreach ($error as $key2 => $value2) {
                    $this->errors[$key2][] = $value2;
                }
            }
            $this->errors[$key][] = $value;
        }
        return $this;
    }

    public static function create(array $post): static
    {
        if (static::query()->where('email', $post['email'])->first()) {
            return (new static())->setErrors(['email' => 'Такой пользователь уже существует']);
        }
        $user = new static();
        $user->first_name = $post['first_name'];
        $user->last_name = $post['last_name'];
        $user->email = $post['email'];
        $user->password_hash = bcrypt($post['password']);
        if ($user->save() && $user->login()) {
            return $user;
        }
        return (new static())->setErrors(['email' => 'Произошла не предвиденная ошибка']);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'id', 'user_id')->select([
            'ax_wallet.*',
            'wc.name as wallet_currency_name',
            'wc.title as wallet_currency_title',
            'wc.is_national as wallet_currency_is_national',
        ])
            ->join('ax_wallet_currency as wc', 'wc.id', '=', 'ax_wallet.wallet_currency_id');
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['user_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

}
