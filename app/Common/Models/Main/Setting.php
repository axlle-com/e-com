<?php

namespace App\Common\Models\Main;

use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * This is the model class for table "{{%setting}}".
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
class Setting extends BaseModel
{
    use EventSetter;
    use Singleton;

    public string $template = '';
    protected $table = 'ax_setting';
    private int $cnt = 0;

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public function setCache(): static
    {
        $this->template = config('app.template');
        $data = array_merge($this->toArray(), ['template' => $this->template]);
        Cache::put('_setting', $data);
        return $this;
    }

    /**
     * @throws Exception
     */
    public static function get(): array
    {
        if (Cache::has('_setting')) {
            $cache = Cache::get('_setting');
            $template = $cache['template'] ?? '';
            if ($template === config('app.template')) {
                static::model()->setTemplate(config('app.template'));
                return Cache::get('_setting');
            }
        }
        $self = static::model()->setCache();
        if ($self->cnt > 2) {
            throw new Exception('Превышел лимит попыток получить настройки');
        }
        $self->cnt++;
        return self::get();
    }

    public static function template(): string
    {
        $temp = self::get()['template'] ?? '';
        return 'frontend.template.' . $temp . '.';
    }

    public function setTemplate(string $template): static
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
