<?php

namespace App\Common\Models\History;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Query;

class MainHistory extends BaseModel
{
    protected $table = 'ax_main_history';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public static function joinHistory(Builder $query, string $table): Builder
    {
        $query->addSelect([
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
        ])
              ->leftJoin(self::table() . ' as ev', static function ($join) use ($table) {
                  /** @var Query $join */
                  $join->on('ev.resource_id', '=', $table . '.id')
                       ->where('ev.resource', '=', $table)
                       ->where('ev.event', '=', 'created');
              })
              ->leftJoin('ax_user as user', 'ev.user_id', '=', 'user.id')
              ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id');
        return $query;
    }
}