<?php

namespace App\Common\Console\Commands;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\InfoBlock;
use App\Common\Models\Render;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use App\Common\Models\Widgets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        DB::table('ax_wallet_transaction_subject')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 10; $i++) {
            $model = new Render();
            $model->title = 'Шаблон №'.$i;
            $model->name = (new PostCategory())->getTable();
            $model->resource = $model->name;
            $model->safe();
        }

        for ($i = 0; $i < 10; $i++) {
            $model = new PostCategory();
            $model->title = 'PostCategory №'.$i;
            $model->url = 'PostCategory'.$i;
            $model->alias = 'PostCategory'.$i;
            $model->safe();
        }

        for ($i = 0; $i < 10; $i++) {
            $model = new Post();
            $model->title = 'Post №'.$i;
            $model->url = 'Post'.$i;
            $model->alias = 'Post'.$i;
            $model->safe();
        }

        for ($i = 0; $i < 10; $i++) {
            $model = new Widgets();
            $model->title = 'Widgets №'.$i;
            $model->name = 'Widgets'.$i;
            $model->safe();
        }

        for ($i = 0; $i < 10; $i++) {
            $model = new InfoBlock();
            $model->title = 'InfoBlock №'.$i;
            $model->alias = 'InfoBlock'.$i;
            $model->safe();
        }

        $currency = [
            'USD' => ['Доллар США', 'R01235', null],
            'RUB' => ['Российский рубль', null, 1]
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
        foreach ($currency as $key => $item) {
            if (WalletCurrency::query()->where('name', $key)->where('currency_id', $item[1])->first()) {
                continue;
            }
            $model = new WalletCurrency();
            $model->name = $key;
            $model->title = $item[0];
            $model->currency_id = $item[1] ?? null;
            if ($item[2]) {
                $model->is_national = $item[2];
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
