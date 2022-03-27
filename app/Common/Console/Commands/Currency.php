<?php

namespace App\Common\Console\Commands;

use App\Common\Components\CurrencyParser;
use Illuminate\Console\Command;

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
