<?php

use App\Common\Console\Commands\DB\FillData;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new FillData())->createLaravelNestedSet();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new FillData())->dropLaravelNestedSet();
    }
};
