<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_counterparty}}".
 *
 * @property int $user_id
 * @property int $is_individual
 * @property string|null $name
 * @property string|null $name_full
 */
class Counterparty extends BaseModel
{
    protected $table = 'ax_counterparty';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public static function createOrUpdate(array $post):static
    {
        $self = new static();
        $self->user_id = $post['user_id'];
        $self->is_individual = $post['is_individual'] ?? 0;
        return $self->safe();
    }

}
