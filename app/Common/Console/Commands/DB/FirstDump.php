<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use function storage_path;

class FirstDump extends Command
{
    protected $signature = 'first:dump';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::dropAllTables();
        $path = storage_path('db/db.sql');
        if (file_exists($path)) {
            $migration = new MigrationClass();
            $result = DB::connection($migration->getConnection())->unprepared(file_get_contents($path));
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
        }
    }
}
