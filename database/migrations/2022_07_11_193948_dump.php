<?php

require_once base_path('database/migrations-out/2022_03_22_162143_create_permission_tables.php');

use App\Common\Console\Commands\DB\Fursie;
use App\Common\Console\Commands\DB\Linoor;
use App\Common\Console\Commands\DB\Tokyo;
use App\Common\Models\Errors\Errors;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    use Errors;

    public function up(): void
    {
        ###### new project tokyo
        if(config('app.template') === 'tokyo') {
            (new Tokyo())->handle();
        }
        ###### new project fursie
        if(config('app.template') === 'fursie') {
            (new Fursie())->handle();
        }
        ###### new project linoor
        if(config('app.template') === 'linoor') {
            (new Linoor())->handle();
        }
    }

    public function down(): void
    {
        echo 'not down' . PHP_EOL;
    }
};
