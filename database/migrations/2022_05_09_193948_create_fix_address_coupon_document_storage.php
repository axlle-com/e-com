<?php

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
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
