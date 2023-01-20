<?php

namespace App\Common\Models\Url;

use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%main_url}}".
 *
 * @property int $id
 * @property string $alias
 * @property string $url
 * @property string $url_old
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class MainUrl extends BaseModel
{
    use HasHistory;

    protected $table = 'ax_main_url';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::query()->where(self::table() . '.id', $post['id'])->first()) {
            return self::create($post);
        }
        return $model->loadModel($post)->safe();
    }

    public function setUrl(string $alias = null): static
    {
        $this->url = $alias ?? $this->alias;
        return $this;
    }
}
