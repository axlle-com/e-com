<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropAllTables();
        $db = storage_path('db/_db.sql');
        if (file_exists($db)) {
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
        }
    }

    public function down(): void
    {
        Schema::dropAllTables();
    }
};
