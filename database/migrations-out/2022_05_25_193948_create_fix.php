<?php

require_once base_path('database/migrations-out/2022_03_22_162143_create_permission_tables.php');

if (!defined('IS_MIGRATION')) {
    define('IS_MIGRATION', true);
}

use App\Common\Console\Commands\DB\FillData;
use App\Common\Models\Catalog\Document\Coming\DocumentComing;
use App\Common\Models\Catalog\Document\Coming\DocumentComingContent;
use App\Common\Models\Catalog\Document\WriteOff\DocumentWriteOff;
use App\Common\Models\Catalog\Document\WriteOff\DocumentWriteOffContent;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use App\Common\Models\History\MainHistory;
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
        $dump_fix = storage_path('db/dump_fix.sql');
        $db = storage_path('db/_db.sql');
        $docs = [];
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
        }
        ###### Склады
        FillData::setCatalogStoragePlace();
        ###### Виды документов
        FillData::setCatalogDocumentSubject();
        ###### Контрагент
        FillData::setCounterparty();
        ###### Статус доставки
        FillData::setCatalogDeliveryStatus();
        ###### Статус оплаты
        FillData::setCatalogPaymentStatus();
        ###### Тип доставки
        FillData::setCatalogDeliveryType();
        ###### Изменение товара
        FillData::changeCatalogProduct();
        ###### Ошибки
        FillData::setMainErrorsType();

        Schema::enableForeignKeyConstraints();
        foreach ($docs as $value) {
            if ($value['subject_name'] === 'coming') {
                $coming = DocumentComing::createOrUpdate($value, false)->posting();
                echo $coming->message ? $coming->message . PHP_EOL : '';
            }
        }
        foreach ($docs as $value) {
            if ($value['subject_name'] === 'write_off') {
                $coming = DocumentWriteOff::createOrUpdate($value, false)->posting();
                echo $coming->message ? $coming->message . PHP_EOL : '';
            }
        }
        ###### event DocumentComing
        $this->eventDocumentComing();
        ###### event DocumentWriteOff
        $this->eventDocumentWriteOff();
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }

    private function event($models): void
    {
        foreach ($models as $value) {
            try {
                $body = [
                    'model' => $value->toArray(),
                    'changes' => $value->getChanges(),
                ];
                DB::table(MainHistory::table())->insertGetId(
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
                $this->setErrors(_Errors::exception($exception, $this));
            }
        }
    }

    private function eventDocumentComing(): void
    {
        $this->event(DocumentComing::all());
        ###### event DocumentComingContent
        $this->event(DocumentComingContent::all());
    }

    private function eventDocumentWriteOff(): void
    {
        $this->event(DocumentWriteOff::all());
        ###### event DocumentComingContent
        $this->event(DocumentWriteOffContent::all());
    }
};
