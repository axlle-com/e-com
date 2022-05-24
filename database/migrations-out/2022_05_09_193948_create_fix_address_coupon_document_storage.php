<?php

use App\Common\Models\Catalog\CatalogDocumentSubject;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\FinTransactionType;
use App\Common\Models\User\UserWeb;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        $path = storage_path('db/fix.sql');
        if (file_exists($path)) {
            Schema::disableForeignKeyConstraints();
            $result = DB::connection($this->getConnection())->unprepared(file_get_contents($path));
            Schema::enableForeignKeyConstraints();
            echo $result ? 'ok' . PHP_EOL : 'error' . PHP_EOL;
            UserWeb::setAuth(6);
            /* @var $item CatalogProduct */
            foreach (CatalogProduct::all() as $item) {
                $item->is_published = 0;
                if (!$item->price) {
                    $item->price = 2000;
                }
                $item->safe()->setIsPublished('on')->safe();
                echo $item->getErrorsString() ? $item->getErrorsString() . PHP_EOL : '';
            }

            ###### Виды документов
            $this->setCatalogDocumentSubject();
        }
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }

    private function setCatalogDocumentSubject(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_catalog_document_subject')->truncate();
        Schema::enableForeignKeyConstraints();

        $events = [
            'sale' => ['Продажа', 'debit'],
            'refund' => ['Возврат', 'credit'],
            'coming' => ['Поступление', 'credit'],
            'write_off' => ['Списание', 'debit'],
            'reservation' => ['Резервирование', 'debit'],
            'remove_reserve' => ['Снятие с резерва', 'credit'],
        ];
        $types = FinTransactionType::all();
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (CatalogDocumentSubject::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new CatalogDocumentSubject();
            $model->name = $key;
            $model->title = $event[0];
            $model->fin_transaction_type_id = $types->where('name', $event[1])->first()->id;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Document Subject' . PHP_EOL;
    }
};
