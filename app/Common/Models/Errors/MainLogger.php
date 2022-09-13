<?php

namespace App\Common\Models\Errors;

use Exception;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_main_logger}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ips_id
 * @property string $uuid
 * @property string $channel
 * @property string $level
 * @property string $title
 * @property string|null $body
 * @property float $created_at
 *
 */
class MainLogger extends BaseModel
{
    protected $table = 'ax_main_logger';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected function getDateFormat(): string
    {
        return 'U';
    }

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
            $self->body = @json_encode($error['body'], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            $self->save();
        } catch (Exception $exception) {
        }
    }
}
