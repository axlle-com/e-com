<?php

use App\Common\Models\Errors\Errors;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use Errors;

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/invoice.sql');
        if (file_exists($db)) {
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
