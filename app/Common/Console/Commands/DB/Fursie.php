<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Fursie extends Command
{
    protected $signature = 'fursie:start';
    protected $description = 'Command description';

    public function handle(): void
    {
        if (config('app.template') !== 'fursie'){
            return;
        }
        Schema::dropAllTables();
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/db.sql');
        $dump = storage_path('db/dump.sql');
        if (file_exists($db) && file_exists($dump)) {
            $migration = new MigrationClass();
            $result = DB::connection($migration->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            $data = new FillData();
            $data->createPermissionTables();
            $data->createJobsTables();
            $data->createFailedJobsTables();
            $result = DB::connection($migration->getConnection())->unprepared(file_get_contents($dump));
            echo $result ? 'ok dump.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        Schema::enableForeignKeyConstraints();
    }
}
