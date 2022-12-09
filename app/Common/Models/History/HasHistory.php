<?php

namespace App\Common\Models\History;

use App\Common\Jobs\HistoryJob;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Query;

trait HasHistory
{
    public bool $isHistory = true;
    private ?User $_user;

    public function setHistory(string $event): void
    {
        /** @var $this BaseModel */
        if (!$this->isHistory) {
            return;
        }
        try {
            $data = [
                'ip' => $this->getUser()->ip ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'user_id' => $this->getUser()->id ?? null,
                'resource' => $this->getTable(),
                'resource_id' => $this->id,
                'event' => $event,
                'body' => @json_encode($this->getDirty(), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
                'created_at' => time(),
            ];
            HistoryJob::dispatch($data);
        } catch (Exception $exception) {
            if (method_exists($this, 'setErrors')) {
                $this->setErrors(_Errors::exception($exception, $this));
            }
        }
    }

    public function getUser(): ?User
    {
        if (empty($this->_user)) {
            $this->setUser();
        }
        return $this->_user;
    }

    public function setUser(?User $user = null): static
    {
        if ($user) {
            $this->_user = $user;
        } else if (($userAuth = UserWeb::auth()) || ($userAuth = UserRest::auth()) || ($userAuth = UserApp::auth())) {
            $this->_user = $userAuth;
        } else {
            $this->_user = null;
        }
        return $this;
    }

    public function scopeJoinHistory(Builder $query): Builder
    {
        $table = $this->getTable();
        $query->addSelect([
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
        ])
            ->leftJoin(MainHistory::table() . ' as ev', static function ($join) use ($table) {
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
