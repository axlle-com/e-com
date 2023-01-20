<?php

namespace App\Common\Jobs;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\History\MainHistory;
use App\Common\Models\Ips;
use Exception;
use Illuminate\Support\Facades\DB;

class HistoryJob extends BaseJob
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        parent::__construct();
    }

    public function handle()
    {
        try {
            DB::table(MainHistory::table())->insertGetId($this->getData());
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        parent::handle();
    }

    private function getData(): array
    {
        $this->data['ips_id'] = $this->getIpsId();
        unset($this->data['ip']);
        return $this->data;

    }

    private function getIpsId(): ?int
    {
        $post['ip'] = $this->data['ip'] ?? '127.0.0.1';
        return Ips::createOrUpdate($post)?->id;
    }
}