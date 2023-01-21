<?php

namespace App\Common\Models\Setting;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseComponent;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use ReflectionClass;

/**
 * This is the Service class for table "{{%setting}}".
 *
 * @property int $id
 * @property string $key
 * @property string|null $title
 * @property string|null $description
 * @property string|null $value_string
 * @property string|null $value_text
 * @property string|null $value_json
 * @property string|null $value_bool
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class Setting extends BaseComponent
{
    public const KEY_TEMPLATE = 'template';
    public const KEY_NOTICE_TYPE = 'notice_type';
    public const KEY_TELEGRAM_BOT_TOKEN = 'telegram_bot_token';
    public const KEY_ROBOTS = 'robots';
    public const KEY_GOOGLE_VERIFICATION = 'google_verification';
    public const KEY_YANDEX_VERIFICATION = 'yandex_verification';
    public const KEY_YANDEX_METRIKA = 'yandex_metrika';
    public const KEY_GOOGLE_ANALYTICS = 'google_analytics';
    public const KEY_LOGO_GENERAL = 'logo_general';
    public const KEY_LOGO_SECOND = 'logo_second';
    public const KEY_COMPANY_NAME = 'company_name';
    public const KEY_COMPANY_NAME_FULL = 'company_name_full';
    public const KEY_COMPANY_PHONE = 'company_phone';
    public const KEY_COMPANY_EMAIL = 'company_email';
    public const KEY_COMPANY_ADDRESS = 'company_address';
    public const KEY_REDIRECT_ON = 'redirect_on';

    public string $template = '';
    private array $cache = [];
    private int $cnt = 0;

    public static function template(): string
    {
        try {
            $temp = self::get('template') ?? '';
        } catch (Exception $exception) {
        }
        return !empty($temp) ? 'frontend.template.' . $temp . '.' : 'frontend.';
    }

    /**
     * @throws Exception
     */
    public static function get(?string $key = null): mixed
    {
        $self = self::model();
        if ($self->cache) {
            if ($key) {
                return $self->cache[$key] ?? null;
            }
            return $self->cache;
        }
        if (config('app.test')) {
            self::model()->setCache()->cache;
        }
        if (Cache::has('_setting')) {
            $self->cache = Cache::get('_setting');
            $template = $self->cache['template'] ?? '';
            if ($template === config('app.template')) {
                $self->setTemplate(config('app.template'));
                if ($key) {
                    return $self->cache[$key] ?? null;
                }
                return $self->cache;
            }
        }
        $self = self::model()->setCache();
        if ($self->cnt > 2) {
            throw new Exception('Превышел лимит попыток получить настройки');
        }
        $self->cnt++;
        return self::get($key);
    }

    public function setCache(): static
    {
        $this->template = config('app.template');
        $bd = MainSetting::query()->get();
        $array = [];
        foreach ($bd as $line) {
            if ($key = self::keys($line['key'])) {
                $array[$line['key']]['bd'] = $line->toArray();
                $array[$line['key']]['setting'] = $key;
            }
        }
        $array[self::KEY_TELEGRAM_BOT_TOKEN]['bd'] = Crypt::encryptString(config('services.telegram-bot-api')['token']);
        $array[self::KEY_TELEGRAM_BOT_TOKEN]['setting'] = self::keys(self::KEY_TELEGRAM_BOT_TOKEN);
        $this->cache = array_merge($array, ['template' => $this->template]);
        Cache::put('_setting', $this->cache);
        return $this;
    }

    public static function keys(string $key = null): ?array
    {
        $keys = [
            self::KEY_TEMPLATE => [
                'type' => 'string',
                'field' => 'value_string',
                'is_encrypt' => false,
            ],
            self::KEY_NOTICE_TYPE => [
                'type' => 'array',
                'is_encrypt' => false,
                'field' => 'value_json',
                'array' => [
                    'telegram' => [],
                    'email' => [],
                    'sms' => [],
                ],
            ],
            self::KEY_TELEGRAM_BOT_TOKEN => [
                'type' => 'string',
                'is_encrypt' => true,
                'field' => 'value_string',
            ],
            self::KEY_ROBOTS => [
                'type' => 'text',
                'is_encrypt' => false,
                'field' => 'value_text',
            ],
            self::KEY_GOOGLE_VERIFICATION => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_YANDEX_VERIFICATION => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_YANDEX_METRIKA => [
                'type' => 'text',
                'is_encrypt' => false,
                'field' => 'value_text',
            ],
            self::KEY_GOOGLE_ANALYTICS => [
                'type' => 'text',
                'is_encrypt' => false,
                'field' => 'value_text',
            ],
            self::KEY_LOGO_GENERAL => [
                'type' => 'file',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_LOGO_SECOND => [
                'type' => 'file',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_COMPANY_NAME => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_COMPANY_NAME_FULL => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_COMPANY_EMAIL => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_COMPANY_ADDRESS => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_REDIRECT_ON => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
            self::KEY_COMPANY_PHONE => [
                'type' => 'string',
                'is_encrypt' => false,
                'field' => 'value_string',
            ],
        ];
        return $key ? ($keys[$key] ?? null) : $keys;
    }

    public function init(): static
    {
        $this->setCache();
        return parent::init();
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getConstants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    public function __call($name, $arguments)
    {
        $name = strtoupper(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
        $array = [
            'GET_',
            'KEY_',
        ];
        $name = self::class . '::KEY_' . str_replace($array, '', trim($name));
        if (defined($name)) {
            return $this->getValue(constant($name));
        }
        return null;
    }

    private function getValue(string $key)
    {
        if (($all = $this->cache[$key] ?? null) && $value = $all['bd'] ?? null) {
            if ($all['setting']['is_encrypt'] && is_string($value)) {
                try {
                    return Crypt::decryptString($value);
                } catch (Exception $exception) {
                    $this->setErrors(_Errors::exception($exception, $this));
                }
            }
            return $value;
        }
        return null;
    }
}
