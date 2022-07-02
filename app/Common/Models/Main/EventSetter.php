<?php

namespace App\Common\Models\Main;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Ips;
use App\Common\Models\User\User;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\DB;

/**
 * @property Ips|null $ipSetter
 * @property string|null $ip_date
 * @property string|null $ip_event
 */
trait EventSetter
{
    public ?Ips $ipSetter;
    public string $tableEvent = 'ax_main_events';
    public ?User $userSetter;
    public bool $isEvent = true;
    public bool $isUser = true;

    public function setUser(?User $user = null): static
    {
        if ($user) {
            $this->userSetter = $user;
        } else if (($userAuth = UserWeb::auth()) || ($userAuth = UserRest::auth()) || ($userAuth = UserApp::auth())) {
            $this->userSetter = $userAuth;
        } else {
            $this->userSetter = null;
        }
        return $this;
    }

    public function setIp(): static
    {
        /* @var $this BaseModel */
        $post['ip'] = $this->userSetter->ip ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $this->ipSetter = Ips::createOrUpdate($post);
        return $this;
    }

    public function setIpEvent(string $event): void
    {
        /* @var $this BaseModel */
        if (!$this->isEvent) {
            return;
        }
        try {
            $this->setUser()->setIp();
            $body = [
                'model' => $this->toArray(),
                'changes' => $this->getChanges(),
            ];
            DB::table($this->tableEvent)->insertGetId(
                [
                    'ips_id' => $this->ipSetter->id ?? Ips::query()->where('ip', '127.0.0.1')->first()->id ?? null,
                    'user_id' => $this->isUser ? ($this->userSetter->id ?? null) : null,
                    'resource' => $this->getTable(),
                    'resource_id' => $this->id,
                    'event' => $event,
                    'body' => json_encode($body, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
                    'created_at' => time(),
                ]
            );
        } catch (\Exception $exception) {
            if (method_exists($this, 'setErrors')) {
                $this->setErrors(_Errors::exception($exception, $this));
            }
        }
    }
}
