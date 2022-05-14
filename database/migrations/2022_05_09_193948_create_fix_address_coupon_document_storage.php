<?php

use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogProduct;
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
        }
        ###### Типы Delivery
        $this->fixCatalogDeliveryType();
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }

    private function fixCatalogDeliveryType(): void
    {
        /* @var $model CatalogDeliveryType */
        if ($model = CatalogDeliveryType::query()->where('title', 'Курьером по городу')->first()) {
            $model->title = 'Курьером по г.Краснодару';
            echo $model->safe()->getErrors() ? $model->getErrorsString() . PHP_EOL : 'ok' . PHP_EOL;
        }
    }
};
