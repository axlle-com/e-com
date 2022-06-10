<?php

namespace App\Common\Models\Main;

use App\Common\Models\Ips;
use App\Common\Models\User\User;
use Illuminate\Support\Facades\DB;

/**
 * @property Ips|null $ipModel
 * @property string|null $ip_date
 * @property string|null $ip_event
 */
trait IpTrait
{
    public ?Ips $ipModel;
    public ?User $userModel;
    public string $tableEvent = 'ax_main_ips_has_resource';

    public function setIp(?string $ip): static
    {
        /* @var $this BaseModel */
        $post['ip'] = $ip;
        $this->ipModel = Ips::createOrUpdate($post);
        return $this;
    }

    public function setIpEvent(string $event): void
    {
        _dd_($this);
        /* @var $this BaseModel */
        try {
            DB::table($this->tableEvent)->insertGetId(
                [
                    'ips_id' => $this->ipModel->ip,
                    'user_id' => $this->userModel->id,
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
