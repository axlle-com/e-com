<?php

require_once base_path('database/migrations-out/2022_03_22_162143_create_permission_tables.php');

use App\Common\Models\Errors\Errors;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use Errors;

    public function up(): void
    {
        ###### update project
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/db.sql');
        if (file_exists($db)) {
            Schema::dropAllTables();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            (new CreatePermissionTables)->up();
        }
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
