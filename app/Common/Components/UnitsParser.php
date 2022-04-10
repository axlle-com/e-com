<?php

namespace App\Common\Components;

use App\Common\Models\UnitOkei;
use Shuchkin\SimpleXLS;

class UnitsParser
{
    private string $path;
    private array $errors = [];

    public function __construct(string $path = null)
    {
        $this->path = $path ?? storage_path('db/okei.xls');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $error): self
    {
        if (empty($this->errors)) {
            $this->errors = [];
        }
        $this->errors = array_merge_recursive($this->errors, $error);
        return $this;
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
                        $code = ax_clear_data($item[1]);
                        if ($product = UnitOkei::query()->where(['code' => $code])->first()) {
                            $cnt++;
                            continue;
                        }
                        $product = new UnitOkei();
                        $prop = ax_clear_data($item[3]);
                        $title = ax_clear_data($item[2]);
                        $product->title = $title;
                        $product->code = $code;
                        $product->national_symbol = ax_clear_data($item[3]);
                        $product->national_code = ax_clear_data($item[4]);
                        $product->international_symbol = ax_clear_data($item[5]);
                        $product->international_code = ax_clear_data($item[6]);
                        if (!$err = $product->safe()->getErrors()) {
                            echo 'save units' . PHP_EOL;
                        } else {
                            echo 'Not save units' . implode('|', $err) . PHP_EOL;
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
