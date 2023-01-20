<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;

/**
 * # php artisan first:dump
 *
 */
class FirstDump extends Command
{
    protected $signature = 'first:dump';
    protected $description = 'Command description';

    public function handle(): void
    {
        ###### update project
        if (config('app.template') === 'tokyo') {
            (new Tokyo())->handle();
        }
        if (config('app.template') === 'fursie') {
            (new Fursie())->handle();
        }
    }
}
