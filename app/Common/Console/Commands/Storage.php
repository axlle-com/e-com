<?php

namespace App\Common\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Models\Errors\_Errors;

class Storage extends Command
{
    protected $signature = 'reserve {--p=}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $argv[2] = ' &';
        $options = $this->options();
        sleep(20);
        _Errors::error('error', $this);
        echo 'echo' . PHP_EOL;
    }
}
