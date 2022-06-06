<?php

namespace App\Common\Models\User;

use App\Common\Components\Sms\SMSRU;
use App\Common\Models\Blog\Post;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Main\Errors;
use App\Common\Models\Main\Password;
use App\Common\Models\Wallet\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use stdClass;

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
 * @property int $is_phone
 * @property int $is_email
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
 * @property \App\Common\Models\Catalog\Document\CatalogDocument[] $catalogDocuments
 * @property Post[] $posts
 * @property UserToken[] $userTokens
 * @property Wallet[] $wallets
 *
 * @property UserToken|null $token
 * @property UserToken|null $tokenRefresh
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
    use HasFactory, Notifiable, Password, HasRoles, Errors;

    public const STATUS_ACTIVE = 10;
    public const STATUS_PART_ACTIVE = 9;
    public const STATUS_NEW = 8;

    private static array $instances = [];
    private static array $authGuards = [
        UserRest::class => 'rest',
        UserApp::class => 'app',
        UserWeb::class => 'web',
    ];
    private static array $_authJwt = [];
    public ?UserToken $_access_token = null;
    public ?UserToken $_refresh_access_token = null;
    public ?UserToken $_app_access_token = null;
    public ?UserToken $_app_refresh_access_token = null;
    public ?string $password = null;
    public $remember = null;
    public ?string $ip = null;
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
                    'login' => 'required',
                    'password' => 'required',
                ],
                'registration' => [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'email' => 'nullable|email',
                    'phone' => 'nullable|string',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6'
                ],
                'create_db' => [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'email' => 'required|email',
                    'phone' => 'required|string',
                    'password' => 'required|min:6|confirmed',
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

    public static function auth(string $ip = null)
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            if (UserWeb::class === $subclass) {
                /* @var $user UserWeb */
                if ($user = Auth::user()) {
                    $user->ip = $_SERVER['REMOTE_ADDR'];
                    if (!$user->getSessionRoles()) {
                        $user->setSessionRoles();
                    }
                }
            } else if ($user = Auth::guard(self::$authGuards[$subclass])->user()) {
                $user->ip = $_SERVER['REMOTE_ADDR'];
            }
            self::$instances[$subclass] = $user;
        }
        return self::$instances[$subclass];
    }

    public static function setAuth(int $id)
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            if ($user = $subclass::query()->find($id)) {
                $user->ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            }
            self::$instances[$subclass] = $user;
        }
        return self::$instances[$subclass];
    }

    public static function validate(array $data): ?static
    {
        $login = $data['login'];
        $password = $data['password'];
        $remember = !empty($data['remember']);
        if ($login && ($user = static::findAnyLogin($data)) && Hash::check($password, $user->password_hash)) {
            $user->remember = $remember;
            return $user;
        }
        return null;
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

    public static function create(array $post): static
    {
        $email = $post['email'] ?? null;
        $phone = $post['phone'] ?? null;
        if (empty($email) && empty($phone)) {
            return (new static())->setErrors(['email' => 'Не заполнены обязательные поля']);
        }
        if (self::findAnyLogin($post)) {
            return (new static())->setErrors(['email' => 'Такой пользователь уже существует']);
        }
        $user = new static();
        $user->loadModel($post);
        if ($user->save()) {
            return $user;
        }
        return (new static())->setErrors(['email' => 'Произошла не предвиденная ошибка']);
    }

    public static function createOrUpdate(array $post): static
    {
        $email = $post['email'] ?? null;
        $phone = $post['phone'] ?? null;
        if (empty($email) && empty($phone)) {
            return (new static())->setErrors(['email' => 'Не заполнены обязательные поля']);
        }
        if (!$user = self::findAnyLogin($post)) {
            $user = new static();
        }
        $user->loadModel($post);
        if ($user->save()) {
            return $user;
        }
        return (new static())->setErrors(['email' => 'Произошла не предвиденная ошибка']);
    }

    public function setPhone($phone): static
    {
        $this->phone = $phone ? _clear_phone($phone) : null;
        return $this;
    }

    public function setPassword($password): static
    {
        $this->password_hash = bcrypt($password);
        return $this;
    }

    public static function findAnyLogin(array $post): ?User
    {
        /* @var $user static */
        if (empty($post['login'])) {
            $phone = empty($post['phone']) ? null : _clear_phone($post['phone']);
            $email = empty($post['email']) ? null : $post['email'];
        } else {
            $phone = _clear_phone($post['login']);
            $email = $post['login'];
        }
        if (empty($email) && empty($phone)) {
            return null;
        }
        $user = self::query();
        if ($email) {
            $user->where('email', $email);
        }
        if ($phone) {
            $user->orWhere('phone', $phone);
        }
        $user = $user->first();
        return $user ?: null;
    }

    public function login()
    {
        if ($this instanceof UserWeb) {
            if (Auth::loginUsingId($this->id, $this->remember)) {
                $this->setSessionRoles();
                return true;
            }
            return false;
        }
        if ($this instanceof UserApp) {
            return (new AppToken)->create($this) && (new AppToken)->createRefresh($this);
        }
        if ($this instanceof UserRest) {
            return (new RestToken)->create($this) && (new RestToken)->createRefresh($this);
        }
    }

    public function getAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_access_token) {
            $this->_access_token = $this->token;
        }
        return $this->_access_token;
    }

    public function getRefreshAccessTokenAttribute(): ?UserToken
    {
        if (!$this->_refresh_access_token) {
            $this->_refresh_access_token = $this->tokenRefresh;
        }
        return $this->_refresh_access_token;
    }

    public function token(): HasOne
    {
        $type = '';
        if ($this instanceof UserApp) {
            $type = UserToken::TYPE_APP_ACCESS;
        }
        if ($this instanceof UserRest) {
            $type = UserToken::TYPE_REST_ACCESS;
        }
        if ($this instanceof UserWeb) {
            $type = UserToken::TYPE_VERIFICATION_TOKEN;
        }
        return $this->hasOne(UserToken::class, 'user_id', 'id')->where('type', $type);
    }

    public function tokenRefresh(): HasOne
    {
        $type = '';
        if ($this instanceof UserApp) {
            $type = UserToken::TYPE_APP_REFRESH;
        }
        if ($this instanceof UserRest) {
            $type = UserToken::TYPE_REST_REFRESH;
        }
        return $this->hasOne(UserToken::class, 'user_id', 'id')->where('type', $type);
    }

    public function fields(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
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

    public function avatar(): string
    {
        return '/frontend/assets/img/profile_user.svg';
    }

    public function getPhone(): ?string
    {
        return !empty($this->phone) ? _pretty_phone($this->phone) : null;
    }

    public function isActive(): bool
    {
        return $this->status >= self::STATUS_PART_ACTIVE;
    }

    public function isAdmin(): bool
    {
        return in_array('employee', $this->getSessionRoles(), true);
    }

    public function activateWithMail(): bool
    {
        $this->is_email = 1;
        $this->status = $this->is_phone ? self::STATUS_ACTIVE : self::STATUS_PART_ACTIVE;
        if ($this->save() && $this->login()) {
            $this->token->delete();
            self::$instances[static::class] = $this;
            return true;
        }
        return false;
    }

    public function activateWithPhone(): bool
    {
        $this->is_phone = 1;
        $this->status = $this->is_email ? self::STATUS_ACTIVE : self::STATUS_PART_ACTIVE;
        if ($this->save()) {
            self::$instances[static::class] = $this;
            return true;
        }
        return false;
    }

    public function sendCodePassword(array $post): bool
    {
        $ids = session('auth_key', []);
        if (
            $ids
            && !empty($ids['user'])
            && !empty($ids['code'])
            && !empty($ids['phone'])
            && !empty($ids['expired_at'])
            && $ids['expired_at'] > time()
        ) {
            return true;
        }
        $pass = $this->generatePassword();
        $data = new stdClass();
        $data->to = '+7' . _clear_phone($post['phone']);
        $data->msg = $pass;
        $sms = (new SMSRU())->sendOne($data);
        if ($sms->status === "OK") {
            session(['auth_key' => [
                'user' => $this->id,
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
        $ids = session('auth_key', []);
        $if = $ids
            && !empty($ids['user'])
            && !empty($ids['code'])
            && !empty($ids['phone'])
            && !empty($ids['expired_at'])
            && ($ids['user'] == $this->id)
            && ($ids['code'] == $post['code']);
        if ($if){
            session(['auth_key' => []]);
            if ($ids['expired_at'] > time()) {
                $this->phone = _clear_phone($ids['phone']);
                $this->is_phone = 1;
                $this->status = $this->is_email ? self::STATUS_ACTIVE : self::STATUS_PART_ACTIVE;
                return $this->save();
            }
            return false;
        }
        return false;
    }

    public static function table(string $column = ''): string
    {
        $column = $column ? '.' . trim($column, '.') : '';
        return (new static())->getTable() . $column;
    }

    public static function getAllEmployees(): Collection|array
    {
        $subQuery = DB::raw("(select ax_rights_roles.id from ax_rights_roles where ax_rights_roles.name='employee' limit 1)");
        return static::query()
            ->select([static::table('*')])
            ->join('ax_rights_model_has_roles as hr', static function ($join) use ($subQuery) {
                $join->on('hr.model_id', '=', static::table('id'))
                    ->where('hr.model_type', '=', static::class)
                    ->where('hr.role_id', '=', $subQuery);
            })->get();
    }

    public function setSessionRoles(): void
    {
        $user = session('_user', []);
        $user['roles'] = $this->getRoleNames()->toArray();
        session(['_user' => $user]);
    }

    public function getSessionRoles(): array
    {
        $user = session('_user', []);
        return $user['roles'] ?? [];
    }

    public function loadModel(array $data = []): static
    {
        $array = $this::rules('create_db');
        foreach ($data as $key => $value) {
            $setter = 'set' . Str::studly($key);
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            } else {
                $this->{$key} = $value;
            }
            unset($array[$key]);
        }
        $this->setDefaultValue();
        if ($array) {
            foreach ($array as $key => $value) {
                if (!$this->{$key} && Str::contains($value, 'required')) {
                    $format = 'Поле %s обязательно для заполнения';
                    $this->setErrors([$key => sprintf($format, $key)]);
                }
            }
        }
        return $this;
    }

    protected function setDefaultValue(): void
    {
        $this->status = self::STATUS_NEW;
        $this->is_email = 0;
        $this->is_phone = 0;
        $this->remember_token = Str::random(50);
    }
}
