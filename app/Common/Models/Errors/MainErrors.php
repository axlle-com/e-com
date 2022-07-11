<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_main_errors}}".
 *
 * @property int $id
 * @property int $errors_type_id
 * @property int|null $user_id
 * @property int|null $ips_id
 * @property int|null $model_id
 * @property string|null $model
 * @property string|null $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
class MainErrors extends BaseModel
{
    protected $table = 'ax_main_errors';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(array $error): void
    {
        try {
            $self = new self();
            $self->user_id = $error['user_id'] ?? null;
            $self->ips_id = $error['ips_id'] ?? null;
            $self->errors_type_id = $error['errors_type_id'] ?? null;
            $self->model = $error['model'] ?? null;
            $self->model_id = $error['model_id'] ?? null;
            $self->body = json_encode($error['body'], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            $self->save();
        } catch (\Exception $exception) {
        }
    }
}
