<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_catalog_coupon".
 *
 * @property int $id
 * @property int|null $resource_id
 * @property string|null $resource
 * @property string $value
 * @property int $discount
 * @property int|null $state
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $expired_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class CatalogCoupon extends BaseModel
{
    public const STATUS_NEW = 0;
    public const STATUS_ISSUED = 1;
    public const STATUS_USED = 2;

    public static array $stateArray = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_ISSUED => 'Выдан',
        self::STATUS_USED => 'Использован',
    ];

    protected $table = 'ax_catalog_coupon';

    public static function rules(string $type = 'create'): array
    {
        return [
                'add' => [
                    'discount' => 'required|string',
                    'expired_at' => 'required|string',
                ],
            ][$type] ?? [];
    }

    public static function addArray(array $post): self
    {
        $models = new self();
        $arr = [];
        $count = $post['count'] ?? 1;
        for ($i = 0; $i < $count; $i++) {
            $model = self::createOrUpdate($post);
            if ($err = $model->getErrors()) {
                $models->setErrors($err);
            } else {
                $arr[] = $model;
            }
        }
        return $models->setCollection($arr);
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['id']) || !$model = self::query()->find($post['id'])) {
            $model = new self();
            $model->value = self::generate();
            $model->discount = $post['discount'] ?? 10;
            $model->expired_at = strtotime($post['expired_at']);
        }
        $model->state = $post['status'] ?? self::STATUS_NEW;
        $model->resource = $post['resource'] ?? null;
        $model->resource_id = $post['resource_id'] ?? null;
        return $model->safe();
    }

    public static function generate(int $length = 12): string
    {
        $chars = '1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $symbols = '-';
        $size = strlen($chars) - 1;
        $password = '';
        $i = 0;
        while ($length--) {
            if ($i !== 0 && $i % 3 === 0) {
                $password .= $symbols;
            }
            $password .= $chars[random_int(0, $size)];
            $i++;
        }
        return $password;
    }

    public function getUser(): string
    {
        return '...';
    }

    public function getExpired(): string
    {
        return date('d.m.Y H:i', $this->expired_at);
    }

    public function getState(): string
    {
        return self::$stateArray[$this->state];
    }

}
