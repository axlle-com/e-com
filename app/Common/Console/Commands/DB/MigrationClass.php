<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationClass extends Migration
{
    public function drop()
    {
        echo $this->getConnection();
        Schema::disableForeignKeyConstraints();
        $tables = DB::select('SHOW TABLES');
        _dd_($tables);
        foreach ($tables as $table) {
            foreach ($table as $key => $value) {
                echo $value . PHP_EOL;
                Schema::dropIfExists($value);
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    public function drop1()
    {
        echo $this->getConnection();
        Schema::disableForeignKeyConstraints();
        $tables = DB::select('SHOW TABLES');
        _dd_($tables);
        foreach ($tables as $table) {
            foreach ($table as $key => $value) {
                echo $value . PHP_EOL;
                $str = 'SELECT column_name, data_type
                FROM information_schema.columns
                WHERE table_name = ' . $value . '
                ORDER BY ordinal_position;';
                $result = DB::connection($this->getConnection())->unprepared($str);

            }
        }
        Schema::enableForeignKeyConstraints();
    }

    private function delete()
    {
        // дропаем все таблицы
        $delete_list = DB::select("SELECT 'drop table if exists \"' || tablename || '\" cascade;' as pg_tbl_drop
        FROM pg_tables
        WHERE schemaname='public';");
        foreach ($delete_list as $dkey => $dval) {
            DB::statement($dval->pg_tbl_drop);
        }

        // На всякий случай дропаем все последовательности
        $delete_seq_list = DB::select("SELECT 'drop sequence if exists \"' || relname || '\" cascade;' as pg_sec_drop
                    FROM pg_class
                    WHERE relkind = 'S';");
        foreach ($delete_seq_list as $dkey => $dval) {
            DB::statement($dval->pg_sec_drop);
        }

        $query = 'SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname=\'public\'';
        $tables = array_column(DB::select($query), 'tablename');

        foreach ($tables as $table) {
            DB::statement('drop table ' . $table . ' cascade');
        }
    }
}
