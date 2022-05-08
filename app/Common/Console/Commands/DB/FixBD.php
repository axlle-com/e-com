<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixBD extends Command
{
    protected $signature = 'fix:db';
    protected $description = 'Command description';

    public function handle(): void
    {
        $path = storage_path('db/fix.sql');
        if (file_exists($path)) {
            Schema::disableForeignKeyConstraints();
            $migration = new MigrationClass();
            $result = DB::connection($migration->getConnection())->unprepared(file_get_contents($path));
            Schema::enableForeignKeyConstraints();
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
        }
    }
}
