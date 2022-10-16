<?php

namespace App\Common\Console\Commands\DB;

use CreatePermissionTables;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FirstDump extends Command
{
    protected $signature = 'first:dump';
    protected $description = 'Command description';

    public function handle(): void
    {
        ###### update project
        Schema::disableForeignKeyConstraints();
        $dump_07 = storage_path('db/dump_15_10_2022.sql');
        $db = storage_path('db/db.sql');
        if (file_exists($dump_07) && file_exists($db)) {
            Schema::dropAllTables();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            (new CreatePermissionTables)->up();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($dump_07));
            echo $result ? 'ok dump_15_10_2022.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        Schema::enableForeignKeyConstraints();
    }
}
