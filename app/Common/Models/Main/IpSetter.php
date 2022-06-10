<?php

namespace App\Common\Models\Main;

use App\Common\Models\Ips;
use Illuminate\Support\Facades\DB;

/**
 * @property Ips|null $ipSetter
 * @property string|null $ip_date
 * @property string|null $ip_event
 */
trait IpSetter
{
    public ?Ips $ipSetter;
    public string $tableEvent = 'ax_main_ips_has_resource';

    public function setIp(?string $ip = null): static
    {
        /* @var $this BaseModel */
        $post['ip'] = $this->userSetter->ip ?? $ip;
        $this->ipSetter = Ips::createOrUpdate($post);
        return $this;
    }

    public function setIpEvent(string $event): void
    {
        /* @var $this BaseModel */
        try {
            DB::table($this->tableEvent)->insertGetId(
                [
                    'ips_id' => $this->ipSetter->id ?? null,
                    'user_id' => $this->userSetter->id ?? null,
                    'resource' => $this->getTable(),
                    'resource_id' => $this->id,
                    'event' => $event,
                    'created_at' => time(),
                ]
            );
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $this->setErrors(['exception' => $error . ' in [ ' . static::class . ' ] ' . $exception->getLine()]);
        }
    }
}
