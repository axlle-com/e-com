<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Builder;

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

    public static function forSelect(): array
    {
        $subclass = static::class;
        if (!isset(self::$_modelForSelect[$subclass])) {
            self::$_modelForSelect[$subclass] = static::withIndividual()->get()->toArray();
        }
        return self::$_modelForSelect[$subclass];
    }

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public static function withIndividual(): Builder
    {
        return self::query()->select([
            static::table('*'),
            'user.first_name as user_name',
            'user.last_name',
            'user.patronymic',
        ])->leftJoin('ax_user as user', 'user.id', '=', static::table('user_id'));
    }

    public static function getCounterparty($user_id): static
    {
        $counterparty = self::query()
            ->select([self::table('id')])
            ->where(self::table('user_id'), $user_id)
            ->where(self::table('is_individual'), 1)
            ->first();
        if (!$counterparty) {
            $counterparty = self::createOrUpdate(['user_id' => $user_id, 'is_individual' => 1]);
        }
        return $counterparty;
    }

    public static function createOrUpdate(array $post): static
    {
        $self = new static();
        $self->user_id = $post['user_id'];
        $self->is_individual = $post['is_individual'] ?? 0;
        return $self->safe();
    }

}
