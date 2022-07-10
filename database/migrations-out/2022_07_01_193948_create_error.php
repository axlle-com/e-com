<?php

require_once base_path('database/migrations-out/2022_03_22_162143_create_permission_tables.php');

if (!defined('IS_MIGRATION')) {
    define('IS_MIGRATION', true);
}

use App\Common\Console\Commands\DB\FillData;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentComingContent;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use App\Common\Models\Catalog\Document\DocumentWriteOffContent;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use Errors;

    public function up(): void
    {
        $errors = [];
        ###### update project
        Schema::disableForeignKeyConstraints();
        $db = storage_path('db/db_error.sql');
        if (file_exists($db)) {
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db_error.sql' . PHP_EOL : 'error' . PHP_EOL;
        }
        ###### Ошибки
        FillData::setMainErrorsType();
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
