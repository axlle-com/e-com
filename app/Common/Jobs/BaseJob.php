<?php

namespace App\Common\Jobs;

use App\Common\Models\Errors\Errors;
use App\Common\Models\Errors\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Errors;

    public $deleteWhenMissingModels = true;
    public $tries = 3;

    public function __construct()
    {
        Logger::model()->group(Logger::GROUP_HISTORY)->info(static::class . '->' . __FUNCTION__, $this->toArray());
    }

    public function toArray(): array
    {
        return array_merge(get_object_vars($this), $this->getErrors()?->getErrors() ?: []);
    }

    public function handle()
    {
        Logger::model()->group(Logger::GROUP_HISTORY)->info(static::class . '->' . __FUNCTION__, $this->toArray());
    }
}