<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ClearBD extends Command
{
    protected $signature = 'test:clear';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::dropAllTables();
    }
}
