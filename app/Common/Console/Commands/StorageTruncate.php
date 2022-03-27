<?php

namespace App\Common\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StorageTruncate extends Command
{
    protected $signature = 'storage:truncate';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_catalog_storage_place')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
