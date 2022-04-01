<?php

namespace App\Common\Console\Commands;

use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionReason;
use App\Common\Models\Wallet\WalletTransactionType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestWallet extends Command
{
    protected $signature = 'test:wallet';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_wallet_transaction_reason')->truncate();
        DB::table('ax_wallet_transaction_type')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        Schema::enableForeignKeyConstraints();

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
            if (WalletTransactionReason::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new WalletTransactionReason();
            $model->name = $key;
            $model->title = $event;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' events' . PHP_EOL;

        $cnt = 0;
        foreach ($types as $key => $type) {
            if (WalletTransactionType::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new WalletTransactionType();
            $model->name = $key;
            $model->title = $type;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' types' . PHP_EOL;
    }
}
