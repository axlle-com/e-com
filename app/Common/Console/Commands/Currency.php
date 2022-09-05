<?php

namespace App\Common\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Components\CurrencyParser;

class Currency extends Command
{
    protected $signature = 'cur {--p=}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $options = $this->options();
        echo (new CurrencyParser())->setCurrencyPeriod($options['p'] ?? 1);
    }
}
