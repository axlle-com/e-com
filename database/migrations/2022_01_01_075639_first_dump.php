<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropAllTables();
        $path = storage_path('db/db.sql');
        if (file_exists($path)) {
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($path));
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
        }
    }

    public function down(): void
    {
        Schema::dropAllTables();
    }
};
