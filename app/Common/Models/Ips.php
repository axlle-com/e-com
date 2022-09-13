<?php

namespace App\Common\Models;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Document\CatalogDocument;

/**
 * This is the model class for table "{{%ax_main_ips}}".
 *
 * @property int $id
 * @property string $ip
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocument[] $catalogDocuments
 * @property Comments[] $comments
 * @property IpsHasResource[] $ipsHasResources
 * @property Letters[] $letters
 */
class Ips extends BaseModel
{
    public const STATUS_ACTIVE = 1;
    protected $table = 'ax_main_ips';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(array $post): self
    {
        /* @var $model self */
        if (!empty($post['ip']) && !$model = self::query()->where('ip', $post['ip'])->first()) {
            $model = new self();
            $model->ip = $post['ip'];
        }
        if (!empty($post['ips_id']) && !$model = self::query()->where('id', $post['ips_id'])->first()) {
            $model = new self();
            $model->ip = $post['ip'];
        }
        $model->status = $post['status'] ?? self::STATUS_ACTIVE;
        return $model->safe();
    }
}
