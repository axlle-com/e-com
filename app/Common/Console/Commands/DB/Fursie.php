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
        if (config('app.template') !== 'fursie') {
            return;
        }
        Schema::dropAllTables();
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/_db.sql');
        $dump = storage_path('db/_dump.sql');
        if (file_exists($db) && file_exists($dump)) {
            $migration = new MigrationClass();
            $result = DB::connection($migration->getConnection())
                ->unprepared(str_replace('e_com', 'a_shop',file_get_contents($db)));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            $data = new FillData();
            $data->createPermissionTables();
            $data->insertPermissionTables();
            $data->createJobsTables();
            $data->createFailedJobsTables();
//            $data->createLaravelNestedSet();
            $data->updateUrl();
            $result = DB::connection($migration->getConnection())
                        ->unprepared(str_replace('ax_main_events', 'ax_main_history', file_get_contents($dump)));
            echo $result ? 'ok dump.sql' . PHP_EOL : 'error' . PHP_EOL;
            $data->updateUrl();
        }
        Schema::enableForeignKeyConstraints();
    }
}
