<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Console\Command;

/**
 *
 */
class FirstDump extends Command
{
    # php artisan first:dump
    protected $signature = 'first:dump';
    protected $description = 'Command description';

    public function handle(): void
    {
        ###### new project tokyo
        if (config('app.template') === 'tokyo') {
            (new Tokyo())->handle();
        }
        ###### new project fursie
        if (config('app.template') === 'fursie') {
            (new Fursie())->handle();
        }
    }
}
