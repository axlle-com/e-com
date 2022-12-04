<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Tokyo extends Command
{
    protected $signature = 'tokyo:start';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::dropAllTables();
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/db.sql');
        if (file_exists($db)) {
            $migration = new MigrationClass();
            $result = DB::connection($migration->getConnection())->unprepared(str_replace('a_shop', 'ax_tokyo', file_get_contents($db)));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        Schema::enableForeignKeyConstraints();
        $data = new TokyoData();
        $data->setRender();
        $data->setPage();
        $data->setPostCategory();
        $data->setCatalogPropertyType();
        $data->createPermissionTables();
        $data->createJobsTables();
        $data->createFailedJobsTables();
    }
}
