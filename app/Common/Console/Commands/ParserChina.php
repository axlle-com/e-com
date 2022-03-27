<?php

namespace App\Common\Console\Commands;

use App\Common\Components\Helper;
use App\Common\Models\Catalog\CatalogResource;
use App\Common\Models\Catalog\China\CatalogChinaCategory;
use App\Common\Models\Catalog\China\CatalogChinaSparePart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use SimpleXLS;

class ParserChina extends Command
{
    protected $signature = 'parser:china';
    protected $description = 'Command description';

    public function handle(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_catalog_china_category_has_spare_part')->truncate();
        DB::table('ax_catalog_china_category')->truncate();
        DB::table('ax_catalog_china_spare_part')->truncate();
        Schema::enableForeignKeyConstraints();

        $file = storage_path('db/price_with_code.xls');
        if (file_exists($file)) {
            $xls = new SimpleXLS($file);
            if ($xls->success() && $items = $xls->rows()) {
                $catalogResource = CatalogResource::query()->where(['alias' => 'china-spare-part'])->first();
                $cnt = 0;
                foreach ($items as $item) {
                    if ($cnt === 0) {
                        $cnt++;
                        continue;
                    }
                    if ((bool)$item[2]) {
                        $oem = Helper::clearData($item[2]);
                        if ($product = CatalogChinaSparePart::query()->where(['oem' => $oem])->first()) {
                            $oem = $this->oem($oem);
                        }
                        $product = new CatalogChinaSparePart();
                        $prop = Helper::clearData($item[4]);
                        $title = Helper::clearData($item[3]);
                        $product->title = $prop ? $title . ' (' . $prop . ')' : $title;
                        $product->code = Helper::clearData($item[5]);
                        $alias = Helper::setAlias($product->title);
                        $product->alias = $this->aliasProd($alias);
                        $product->oem = $oem;
                        $product->oem_search = Helper::clearDataAll($oem);
                        $product->uuid = (string)Str::uuid();
                        $product->url = $product->alias;
                        $product->url_site = '-';
                        if ($product->save()) {
                            echo 'save product' . PHP_EOL;
                        } else {
                            echo 'Not save product' . PHP_EOL;
                            die();
                        }
                        if ($categoryCurrent = CatalogChinaCategory::query()->where(['xls_id' => (int)$item[1]])->first()) {
                            $product->catalogChinaCategories()->sync([$categoryCurrent->id]);
                        } else {
                            echo $product->title . ' Not find category ' . $item[1] . PHP_EOL;
                            die();
                        }
                    } else {
                        if ($item[1]) {
                            if (!$parent = CatalogChinaCategory::query()->where(['xls_id' => (int)$item[1]])->first()) {
                                echo 'Not find category' . PHP_EOL;
                                die();
                            }
                            $category = new CatalogChinaCategory();
                            $category->catalog_china_category_id = $parent->id ?? null;
                            $category->uuid = (string)Str::uuid();
                            $category->title = Helper::clearData($item[3]);
                            $alias = Helper::setAlias($category->title);
                            $category->alias = $this->aliasCategory($alias);
                            $category->xls_id = (int)$item[0];
                            $category->url = $category->alias;
                            if ($category->save()) {
                                echo 'save category' . PHP_EOL;
                            } else {
                                echo 'Not save category' . PHP_EOL;
                                die();
                            }
                        } else {
                            $category = new CatalogChinaCategory();
                            $category->catalog_resource_id = $catalogResource->id ?? null;
                            $category->uuid = (string)Str::uuid();
                            $category->title = Helper::clearData($item[3]);
                            $alias = Helper::setAlias($category->title);
                            $category->alias = $this->aliasCategory($alias);
                            $category->xls_id = (int)$item[0];
                            $category->url = $category->alias;
                            if ($category->save()) {
                                echo 'save category' . PHP_EOL;
                            } else {
                                echo 'Not save category' . PHP_EOL;
                                die();
                            }
                        }
                    }
                    $cnt++;
                }
            } else {
                echo 'xls error: ' . $xls->error();
            }
        }
    }

    private function oem(string $oem): string
    {
        $cnt = 1;
        $temp = $oem;
        do {
            $temp = $oem . '/' . $cnt;
            $cnt++;
        } while (CatalogChinaSparePart::query()->where(['oem' => $temp])->first());
        return $temp;
    }

    private function aliasProd(string $alias): string
    {
        $cnt = 1;
        $temp = $alias;
        while (CatalogChinaSparePart::query()->where(['alias' => $temp])->first()) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }

    private function aliasCategory(string $alias): string
    {
        $cnt = 1;
        $temp = $alias;
        while (CatalogChinaCategory::query()->where(['alias' => $temp])->first()) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }
}
