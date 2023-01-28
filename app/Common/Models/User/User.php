<?php

namespace App\Common\Models\User;

use App\Common\Components\Delivery\Cdek;
use App\Common\Models\Blog\Post;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Setting\Setting;
use App\Common\Models\Wallet\Wallet;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

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
 * @property string|null $avatar
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property string|null $password
 * @property string|null $remember
 * @property CatalogBasket[] $catalogBaskets
 * @property Post[] $posts
 * @property UserToken[] $userTokens
 * @property Wallet[] $wallets
 * @property UserToken|null $token
 * @property UserToken|null $tokenRefresh
 * @property DocumentOrder|null $order
 * @property Address|null $address
 *
 * @property UserToken|null $access_token
 * @property UserToken|null $refresh_access_token
 *
 * @property-read Wallet|null $wallet
 * @property-read Address|null $deliveryAddress
 */
class User extends BaseUser
{
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
    public ?Address $address = null;
    public ?DocumentOrder $order = null;
    public ?UserToken $_access_token = null;
    public ?UserToken $_refresh_access_token = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public $remember = null;
    public ?string $ip = null;
    protected string $guard_name = 'web';
    protected $table = 'ax_user';
    protected $dateFormat = 'U';
    protected $fillable = ['email',];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

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
                /** @var $user UserWeb */
                if ($user = Auth::user()) {
                    $user->ip = $_SERVER['REMOTE_ADDR'];
                    if (!$user->getSessionRoles()) {
                        $user->setSessionRoles();
                    }
                }
            } else {
                if ($user = Auth::guard(self::$authGuards[$subclass])->user()) {
                    $user->ip = $_SERVER['REMOTE_ADDR'];
                }
            }
            self::$instances[$subclass] = $user;
        }
        return self::$instances[$subclass];
    }

    public function getSessionRoles(): array
    {
        $user = session('_user', []);
        return $user['roles'] ?? [];
    }

    public function setSessionRoles(): void
    {
        $user = session('_user', []);
        $user['roles'] = $this->getRoleNames()->toArray();
        session(['_user' => $user]);
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

    public static function findAnyLogin(array $post): ?static
    {
        /* @var $user static */
        if (empty($post['login'])) {
            $phone = empty($post['phone']) ? null : _clear_phone($post['phone']);
            $email = empty($post['email']) ? null : $post['email'];
        } else if (str_contains($post['login'], '@')) {
            $email = $post['login'];
        } else {
            $phone = _clear_phone($post['login']);
        }

        if (empty($email) && empty($phone)) {
            return null;
        }
        $user = self::query();
        if (!empty($email)) {
            $user->orWhere('email', $email);
        }
        if (!empty($phone)) {
            $user->orWhere('phone', $phone);
        }
        $user = $user->first();
        return $user ?: null;
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

    public static function createEmpty(?array $post): static
    {
        $phone = empty($post['phone']) ? null : _clear_phone($post['phone']);
        $user = new static();
        if (empty($phone)) {
            return $user->setErrors(_Errors::error(['phone' => 'Не заполнены обязательные поля'], $user));
        }
        if (!$user = self::findAnyLogin($post)) {
            $user = new static();
            $user->first_name = 'Empty';
            $user->last_name = 'Empty';
            $user->is_email = 0;
            $user->is_phone = 0;
            $user->setPhone($phone);
            $user->setPassword(_gen_password());
            $user->remember_token = Str::random(50);
            $user->status = self::STATUS_NEW;
            if (!$user->save()) {
                return $user->setErrors(_Errors::error(['user' => 'Произошла не предвиденная ошибка'], $user));
            }
        }
        return $user;
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

    public static function getAllEmployees(): Collection|array
    {
        $subQuery = DB::raw("(select ax_rights_roles.id from ax_rights_roles where ax_rights_roles.name='employee' limit 1)");
        return static::query()
                     ->select([static::table('*')])
                     ->join('ax_rights_model_has_roles as hr', static function ($join) use ($subQuery) {
                         $join->on('hr.model_id', '=', static::table('id'))
                              ->where('hr.model_type', '=', static::class)
                              ->where('hr.role_id', '=', $subQuery);
                     })
                     ->get();
    }

    public function setImage(string $image): static
    {
        $post['images_path'] = $this->setImagesPath();
        $post['image'] = $image;
        if ($this->avatar) {
            unlink(public_path($this->avatar));
        }
        if ($urlImage = GalleryImage::uploadSingleImage($post)) {
            $this->avatar = $urlImage;
        }
        return $this;
    }

    public function createOrder(array $post): static
    {
        $self = $this;
        try {
            DB::transaction(static function () use ($self, $post) {
                $post['order']['catalog_delivery_type_id'] = (int)$post['order']['catalog_delivery_type_id'];
                $post['delivery']['cdek_tariff'] = (int)($post['delivery']['cdek_tariff'] ?? 0);
                $post['order']['user_id'] = $self->id;
                $post['address']['resource'] = $self->getTable();
                $post['address']['resource_id'] = $self->id;
                $post['address']['type'] = 1;
                $post['address']['is_delivery'] = 1;
                $address = '';
                $sum = 350;
                if ($post['order']['catalog_delivery_type_id'] !== 1) {
                    $self->address = Address::createOrUpdate($post['address']);
                    $address .= $post['address']['region'] . ' ';
                    $address .= $post['address']['city'] . ' ';
                    $address .= $post['address']['street'] . ' ';
                    $address .= $post['address']['house'] . ' ';
                    $address .= $post['address']['apartment'] . ' ';
                } else {
                    if ($post['order']['catalog_delivery_type_id'] === 1) {
                        $tariffs = session('_cdek_tariffs', []);
                        foreach ($tariffs as $type) {
                            foreach ($type as $tariff) {
                                if ($tariff['tariff_code'] == $post['delivery']['cdek_tariff']) {
                                    $sum = $tariff['delivery_sum'];
                                }
                            }
                        }
                        if (in_array($post['delivery']['cdek_tariff'], Cdek::COURIER_DELIVERY_TARIFFS, true)) {
                            $post['address']['address'] = $post['delivery']['address_courier'];
                            $address = $post['delivery']['address_courier'];
                            $self->address = Address::createOrUpdate($post['address']);
                        } else {
                            if (in_array($post['delivery']['cdek_tariff'], Cdek::STORAGE_DELIVERY_TARIFFS, true)) {
                                $pvzAll = Cdek::getPvz();
                                $pvz = $pvzAll['objects_list'][$post['delivery']['cdek_pvz']];
                                $address .= $pvz['city'] . ' ';
                                $address .= $pvz['address'];
                            }
                        }
                        $post['order']['cdek_tariff'] = $post['delivery']['cdek_tariff'] ?? null;
                    }
                }
                $address = trim($address);
                $post['order']['user_id'] = $self->id;
                $post['order']['delivery_address'] = $address;
                $post['order']['delivery_cost'] = $sum;
                $self->order = DocumentOrder::createOrUpdate($post['order']);
                if (isset($self->address) && $self->address->getErrors()) {
                    $self->setErrors($self->address->getErrors());
                }
                if ($self->order->getErrors()) {
                    $self->setErrors($self->order->getErrors());
                }
                if ($self->getErrors()) {
                    throw new RuntimeException($self->message);
                }
            }, 3);
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        return $this;
    }

    public static function createOrUpdate(array $post): static
    {
        $phone = empty($post['phone']) ? null : _clear_phone($post['phone']);
        $user = new static();
        if (empty($phone)) {
            return $user->setErrors(_Errors::error(['phone' => 'Не заполнены обязательные поля'], $user));
        }
        if (!$user = self::findAnyLogin($post)) {
            $user = new static();
            $user->is_email = 0;
            $user->is_phone = 0;
            $user->remember_token = Str::random(50);
        } else {
            unset($post['password']);
        }
        $user->loadModel($post);
        $user->status = (self::STATUS_NEW + $user->is_email + $user->is_phone);
        if ($user->save()) {
            return $user;
        }
        return $user->setErrors(_Errors::error(['user' => 'Произошла не предвиденная ошибка'], $user));
    }

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
                'phone' => 'required|string',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ],
            'create_db' => [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'nullable|email',
                'phone' => 'required|string',
            ],
            'change_password' => [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ],
        ][$type] ?? [];
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

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'id', 'user_id');
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
        ])->join('ax_wallet_currency as wc', 'wc.id', '=', 'ax_wallet.wallet_currency_id');
    }

    public function avatar(): string
    {
        $template = Setting::model()->getTemplate();
        return $this->getImage() ?: '/frontend/' . $template . '/assets/img/profile_user.svg';
    }

    public function getPhone(): ?string
    {
        return !empty($this->phone) ? _pretty_phone($this->phone) : null;
    }

    public function isActive(): bool
    {
        return $this->status >= self::STATUS_PART_ACTIVE;
    }

    public function isEmployee(): bool
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

    public function login()
    {
        if ($this instanceof UserWeb) {
            if (Auth::loginUsingId($this->id, $this->remember)) {
                $this->setSessionRoles();
                $this->setHistory(__FUNCTION__);
                return true;
            }
            return false;
        }
        if ($this instanceof UserApp) {
            $this->setHistory(__FUNCTION__);
            return (new AppToken)->new($this) && (new AppToken)->createRefresh($this);
        }
        if ($this instanceof UserRest) {
            $this->setHistory(__FUNCTION__);
            return (new RestToken)->new($this) && (new RestToken)->createRefresh($this);
        }
    }

    public static function create(array $post): static
    {
        $user = new static();
        $email = $post['email'] ?? null;
        $phone = empty($post['phone']) ? null : _clear_phone($post['phone']);
        if (empty($email) && empty($phone)) {
            return $user->setErrors(_Errors::error([
                'email' => 'Не заполнены обязательные поля',
                'phone' => 'Не заполнены обязательные поля',
            ], $user));
        }
        if (self::findAnyLogin($post)) {
            return $user->setErrors(_Errors::error(['phone' => 'Такой пользователь уже существует'], $user));
        }
        $user->loadModel($post);
        if ($user->save()) {
            return $user;
        }
        return $user->setErrors(_Errors::error(['email' => 'Произошла не предвиденная ошибка'], $user));
    }

    public function activateMail(): bool
    {
        $this->is_email = 1;
        $this->status = $this->is_phone ? self::STATUS_ACTIVE : self::STATUS_PART_ACTIVE;
        return $this->save();
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

    public function changePassword(array $post): bool
    {
        $this->setPassword($post['password']);
        return $this->save();
    }

    public function validateCode(array $post): bool
    {
        $ids = session('auth_key', []);
        $if = $ids && !empty($ids['user']) && !empty($ids['code']) && !empty($ids['phone']) && !empty($ids['expired_at']) && ($ids['user'] == $this->id) && ($ids['code'] == $post['code']);
        if ($if) {
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

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'id', 'resource_id')
                    ->where('resource', self::table())
                    ->where('is_delivery', 1);
    }

    protected function setDefaultValue(): static
    {
        $this->status = self::STATUS_NEW;
        $this->is_email = 0;
        $this->is_phone = 0;
        return $this;
    }
}
