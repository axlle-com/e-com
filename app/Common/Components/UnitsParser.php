<?php

namespace App\Common\Components;

use App\Common\Models\UnitOkei;
use App\Common\Models\Errors\Errors;
use Shuchkin\SimpleXLS;

class UnitsParser
{
    use Errors;

    private string $path;

    public function __construct(string $path = null)
    {
        $this->path = $path ?? storage_path('db/okei.xls');
    }

    public function parse(): void
    {
        $cnt = 0;
        if (file_exists($this->path)) {
            $xls = new SimpleXLS($this->path);
            if ($xls->success() && $items = $xls->rows()) {
                foreach ($items as $item) {
                    if ($cnt === 0) {
                        $cnt++;
                        continue;
                    }
                    if ($item[1]) {
                        $code = _clear_data($item[1]);
                        if ($product = UnitOkei::query()->where(['code' => $code])->first()) {
                            $cnt++;
                            continue;
                        }
                        $product = new UnitOkei();
                        $prop = _clear_data($item[3]);
                        $title = _clear_data($item[2]);
                        $product->title = $title;
                        $product->code = $code;
                        $product->national_symbol = _clear_data($item[3]);
                        $product->national_code = _clear_data($item[4]);
                        $product->international_symbol = _clear_data($item[5]);
                        $product->international_code = _clear_data($item[6]);
                        if ($err = $product->safe()->getErrorsString()) {
                            echo 'Not save units' . $err . PHP_EOL;
                        }
                    }
                    $cnt++;
                }
            } else {
                echo 'xls error: ' . $xls->error();
            }
        }
        echo 'It`s ok ' . $cnt . 'records' . PHP_EOL;
    }
}
