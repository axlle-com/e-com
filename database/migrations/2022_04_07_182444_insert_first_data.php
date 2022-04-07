<?php

use App\Common\Components\CurrencyParser;
use App\Common\Models\Page\PageType;
use App\Common\Models\Wallet\Currency as _Currency;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        $type = [
            ['Входная страница блога', 'ax_post_category',],
            ['Входная страница магазина', 'ax_catalog_category',],
            ['Текстовая страница', 'ax_page',],
        ];
        $i = 1;
        foreach ($type as $value) {
            if (PageType::query()->where('resource', $value[1])->first()) {
                continue;
            }
            $model = new PageType();
            $model->title = $value[0];
            $model->resource = $value[1];
            $model->safe();
            $i++;
        }
        echo 'Add ' . $i . ' PageType' . PHP_EOL;

        if (!_Currency::query()->where('global_id', 'R00000')->first()) {
            $_model = new _Currency();
            $_model->global_id = 'R00000';
            $_model->num_code = 810;
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

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_page_type')->truncate();
        DB::table('ax_currency_exchange_rate')->truncate();
        DB::table('ax_currency')->truncate();
        DB::table('ax_wallet_transaction_subject')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        Schema::enableForeignKeyConstraints();
    }
};
