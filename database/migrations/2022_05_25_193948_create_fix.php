<?php

require_once base_path('database/migrations-out/2022_03_22_162143_create_permission_tables.php');

use App\Common\Console\Commands\DB\FillData;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentComingContent;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        $errors = [];
        ###### update project
        Schema::disableForeignKeyConstraints();
        $dump_fix = storage_path('db/dump_fix.sql');
        $db = storage_path('db/db.sql');
        if (file_exists($dump_fix) && file_exists($db)) {
            Schema::dropAllTables();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($db));
            echo $result ? 'ok db.sql' . PHP_EOL : 'error' . PHP_EOL;
            (new CreatePermissionTables)->up();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($dump_fix));
            echo $result ? 'ok dump_fix.sql' . PHP_EOL : 'error' . PHP_EOL;
            $docs = CatalogDocument::filter()
                ->with(['contents'])
                ->get()
                ->toArray();
//            if (count($docs)) {
//                _dd_($docs);
//                return;
//            }
        }
        ###### Склады
        FillData::setCatalogStoragePlace();
        ###### Виды документов
        FillData::setCatalogDocumentSubject();
        ###### Контрагент
        FillData::setCounterparty();

        Schema::enableForeignKeyConstraints();
        foreach ($docs as $value) {
            if ($value['subject_name'] === 'coming') {
                $coming = DocumentComing::createOrUpdate($value);
                echo $coming->message;
            }
            if ($value['subject_name'] === 'write_off') {
                $coming = DocumentWriteOff::createOrUpdate($value);
                echo $coming->message;
            }
        }
        ###### event DocumentComing
        $com = DocumentComing::all();
        foreach ($com as $value) {
            try {
                $body = [
                    'model' => $value->toArray(),
                    'changes' => $value->getChanges(),
                ];
                DB::table('ax_main_events')->insertGetId(
                    [
                        'ips_id' => 2,
                        'user_id' => 7,
                        'resource' => $value->getTable(),
                        'resource_id' => $value->id,
                        'event' => 'created',
                        'body' => json_encode($body, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
                        'created_at' => $value->created_at,
                    ]
                );
            } catch (\Exception $exception) {
                if (method_exists($this, 'setErrors')) {
                    $error = $exception->getMessage();
                    $this->setErrors(['exception' => $error . ' in [ ' . static::class . ' ] ' . $exception->getLine()]);
                }
            }
        }
        ###### event DocumentComingContent
        $comCon = DocumentComingContent::all();
        foreach ($comCon as $value) {
            try {
                $body = [
                    'model' => $value->toArray(),
                    'changes' => $value->getChanges(),
                ];
                DB::table('ax_main_events')->insertGetId(
                    [
                        'ips_id' => 2,
                        'user_id' => 7,
                        'resource' => $value->getTable(),
                        'resource_id' => $value->id,
                        'event' => 'created',
                        'body' => json_encode($body, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK),
                        'created_at' => $value->created_at,
                    ]
                );
            } catch (\Exception $exception) {
                if (method_exists($this, 'setErrors')) {
                    $error = $exception->getMessage();
                    $this->setErrors(['exception' => $error . ' in [ ' . static::class . ' ] ' . $exception->getLine()]);
                }
            }
        }
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
