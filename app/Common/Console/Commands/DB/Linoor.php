<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Linoor extends Command
{
    protected $signature = 'linoor:start';
    protected $description = 'Command description';

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        if(config('app.template') !== 'linoor') {
            return;
        }
        $migration = new MigrationClass();

        Schema::dropAllTables();
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/_db.sql');
        if(file_exists($db)) {
            $result = DB::connection($migration->getConnection())
                ->unprepared(str_replace('e_com', 'ax_linoor', file_get_contents($db)));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        Schema::enableForeignKeyConstraints();
        $data = new TokyoData();
        $data->createPermissionTables();
        $data->insertPermissionTables();
        $data->insertPermissionTables();
        $data->createJobsTables();
        $data->createFailedJobsTables();
        $data->setRender();
        $data->setPage();
        $data->setPostCategory();
        $data->setPost();
    }
}
