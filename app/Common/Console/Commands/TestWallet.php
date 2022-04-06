<?php

namespace App\Common\Console\Commands;

use App\Common\Components\CurrencyParser;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\InfoBlock;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency as _Currency;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use App\Common\Models\Widgets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestWallet extends Command
{
    protected $signature = 'test:data';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_render')->truncate();
        DB::table('ax_post_category')->truncate();
        DB::table('ax_post')->truncate();
        DB::table('ax_info_block')->truncate();
        DB::table('ax_widgets')->truncate();
        DB::table('ax_currency_exchange_rate')->truncate();
        DB::table('ax_currency')->truncate();
        DB::table('ax_wallet_transaction_subject')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 10; $i++) {
            $model = new Render();
            $model->title = 'Шаблон №' . $i;
            $model->name = (new PostCategory())->getTable();
            $model->resource = $model->name;
            $model->safe();
        }
        echo 'Add ' . $i+1 . ' Render' . PHP_EOL;

        for ($i = 0; $i < 10; $i++) {
            $model = new PostCategory();
            $model->title = 'PostCategory №' . $i;
            $model->url = 'PostCategory' . $i;
            $model->alias = 'PostCategory' . $i;
            $model->safe();
        }
        echo 'Add ' . $i+1 . ' PostCategory' . PHP_EOL;

        for ($i = 0; $i < 10; $i++) {
            $model = new Post();
            $model->title = 'Post №' . $i;
            $model->url = 'Post' . $i;
            $model->alias = 'Post' . $i;
            $model->safe();
        }
        echo 'Add ' . $i+1 . ' Post' . PHP_EOL;

        for ($i = 0; $i < 10; $i++) {
            $model = new Widgets();
            $model->title = 'Widgets №' . $i;
            $model->name = 'Widgets' . $i;
            $model->safe();
        }
        echo 'Add ' . $i+1 . ' Widgets' . PHP_EOL;

        for ($i = 0; $i < 10; $i++) {
            $model = new InfoBlock();
            $model->title = 'InfoBlock №' . $i;
            $model->alias = 'InfoBlock' . $i;
            $model->safe();
        }
        echo 'Add ' . $i+1 . ' InfoBlock' . PHP_EOL;

        if (!_Currency::query()->where('global_id', 'R00000')->first()) {
            $_model = new _Currency();
            $_model->global_id = 'R00000';
            $_model->num_code = 'R00000';
            $_model->char_code = 'RUB';
            $_model->title = 'Российский рубль';
            $_model->save();
        }

        (new CurrencyParser())->setCurrencyPeriod(1);

        $currency = [
            'USD' => _Currency::query()->where('global_id', 'R01235')->first(),
            'RUB' => _Currency::query()->where('global_id', 'R00000')->first(),
        ];
        $events = [
            'stock' => 'Покупка',
            'refund' => 'Возврат',
            'transfer' => 'Перевод',
        ];
        $types = [
            'debit' => 'Расход',
            'credit' => 'Приход',
        ];

        $cnt = 0;
        /* @var $item _Currency */
        foreach ($currency as $key => $item) {
            if (WalletCurrency::query()->where('name', $key)->where('currency_id', $item->id)->first()) {
                continue;
            }
            $model = new WalletCurrency();
            $model->name = $key;
            $model->title = $item->title;
            $model->currency_id = $item->id;
            if ($item->global_id === 'R00000') {
                $model->is_national = 1;
            } else {
                $model->is_national = 0;
            }
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' currency' . PHP_EOL;

        $cnt = 0;
        foreach ($events as $key => $event) {
            if (WalletTransactionSubject::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new WalletTransactionSubject();
            $model->name = $key;
            $model->title = $event;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' events' . PHP_EOL;
    }
}
