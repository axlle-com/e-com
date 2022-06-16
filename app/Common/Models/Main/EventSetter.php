<?php

namespace App\Common\Models\Main;

use App\Common\Models\Ips;
use App\Common\Models\User\User;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\DB;

/**
 * @property Ips|null $eventSetter
 * @property string|null $ip_date
 * @property string|null $ip_event
 */
trait EventSetter
{
    public ?Ips $eventSetter;
    public string $tableEvent = 'ax_main_ips_has_resource';
    public ?User $userSetter;

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
        $post['ip'] = $this->userSetter->ip ?? $_SERVER['REMOTE_ADDR'];
        $this->eventSetter = Ips::createOrUpdate($post);
        return $this;
    }

    public function setIpEvent(string $event): void
    {
        /* @var $this BaseModel */
        try {
            $this->setUser()->setIp();
            $body = [
                'model' => $this->toArray(),
                'changes' => $this->getChanges(),
            ];
            DB::table($this->tableEvent)->insertGetId(
                [
                    'ips_id' => $this->eventSetter->id ?? Ips::query()->where('ip', '127.0.0.1')->first()->id ?? null,
                    'user_id' => $this->userSetter->id ?? null,
                    'resource' => $this->getTable(),
                    'resource_id' => $this->id,
                    'event' => $event,
                    'body' => json_encode($body, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
                    'created_at' => time(),
                ]
            );
        } catch (\Exception $exception) {
            if (method_exists($this, 'setErrors')) {
                $error = $exception->getMessage();
                $this->setErrors(['exception' => $error . ' in [ ' . static::class . ' ] ' . $exception->getLine()]);
            }
        }
    }
}
