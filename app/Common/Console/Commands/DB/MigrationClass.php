<?php

namespace App\Common\Console\Commands\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MigrationClass extends Migration
{
    public function drop(): void
    {
        Schema::disableForeignKeyConstraints();
        function _date($value,$string)
        {
            $string = Schema::getColumnType($value,$string);
            if($string === 'datetime'){
                return 'string';
            }
            if($string === 'integer' || $string === 'bigint'){
                return 'int';
            }
            return $string;
        }
        $str = '';
        $tables = Schema::getAllTables();
        foreach($tables as $table) {
            foreach($table as $key => $value) {
                if(str_starts_with($value, 'pg_') || str_starts_with($value, '_pg_') || str_starts_with($value, 'column_')) {
                    continue;
                }
                $str = '';
                echo $value . PHP_EOL . '<br>';
                echo '/**<br>';
                $str .= '<?php' . PHP_EOL;
                $str .= '/**' . PHP_EOL;

                foreach(Schema::getColumnListing($value) as $_value) {
                    $str .= '* @property $' . _date($value,$_value).' ' . $_value . PHP_EOL;
                }
                $value = str_replace('"public".','',$value);
                $str .= '*/' . PHP_EOL;
                echo '*/' . '<br>';
                echo 'class ' . Str::studly($value) . ' extends Model<br>';
                echo '{' . '<br>';
                echo "protected \$table = '" . $value . "'" . '<br>';
                echo '}' . '<br>';
                file_put_contents(storage_path(Str::studly($value) . '.php'), $str);
                $str = '';
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
