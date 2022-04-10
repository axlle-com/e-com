<?php

use App\Common\Components\UnitsParser;
use App\Common\Models\Catalog\CatalogPropertyUnit;
use App\Common\Models\UnitOkei;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        (new UnitsParser)->parse();

        $arr = [
            'Миллиметр',
            'Сантиметр',
            'Метр',
            'Грамм',
            'Килограмм',
            'Квадратный миллиметр',
            'Квадратный сантиметр',
            'Квадратный метр',
            'Набор',
            'Пара (2 шт.)',
            'Элемент',
            'Упаковка',
            'Штука',
        ];
        foreach ($arr as $item) {
            /* @var $un UnitOkei */
            if (($un = UnitOkei::query()->where('title', $item)->first()) && !CatalogPropertyUnit::query()->where('unit_okei_id', $un->id)->first()) {
                $model = new CatalogPropertyUnit;
                $model->title = $un->title;
                $model->national_symbol = $un->national_symbol;
                $model->international_symbol = $un->international_symbol;
                $model->unit_okei_id = $un->id;
                echo $model->safe()->getErrorsString();
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('insert_units');
    }
};
