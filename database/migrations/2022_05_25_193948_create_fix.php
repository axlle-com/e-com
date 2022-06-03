<?php

require_once '2022_03_22_162143_create_permission_tables.php';

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        ### update project ###
        $dump_25_05_2022 = storage_path('db/dump_03_06_2022.sql');
        $db = storage_path('db/db.sql');
        if (file_exists($dump_25_05_2022) && file_exists($db)) {
            Schema::dropAllTables();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            (new CreatePermissionTables)->up();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($dump_25_05_2022));
            echo $result ? 'ok dump_03_06_2022' . PHP_EOL : 'error' . PHP_EOL;
        }
        ### update project ###
        Schema::enableForeignKeyConstraints();

        ### update product table ###
        if (!Schema::hasColumn('ax_catalog_product', 'is_single')) {
            Schema::table('ax_catalog_product', static function (Blueprint $table) {
                $table->unsignedTinyInteger('is_single')->nullable()->default(0);
            });
        }

    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }

};
