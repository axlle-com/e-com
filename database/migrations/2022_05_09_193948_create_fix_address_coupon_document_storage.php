<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        $path = storage_path('db/fix.sql');
        if (file_exists($path)) {
            Schema::disableForeignKeyConstraints();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($path));
            Schema::enableForeignKeyConstraints();
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
        }
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
