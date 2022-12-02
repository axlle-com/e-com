<?php

namespace App\Common\Assets;

use Exception;
use MatthiasMullie\Minify;
use App\Common\Models\Errors\Errors;
use App\Common\Models\Errors\_Errors;

class Resource
{
    use Errors;

    private static ?self $_instance;
    private array $_css;
    private array $_js;
    private array $_asset;
    private string $resourcesAssetsPath;

    private function __construct()
    {
        $dir = '';
//        try {
//            $dir = _create_path('/public/assets/cache');
//            _gitignore($dir);
//        } catch (Exception $exception) {
//            $this->setErrors(_Errors::exception($exception, $this));
//        }
        $this->resourcesAssetsPath = $dir;
    }

    public static function model(): self
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function addAssets(Asset $asset): self
    {
        $this->_asset[] = $asset;
        return $this;
    }

    public function addCss(array $css): self
    {
        foreach ($css as $link) {
            if (!in_array($link, $this->_css, true)) {
                $this->_css[] = $link;
            }
        }
        return $this;
    }

    public function addJs(array $js): self
    {
        foreach ($js as $link) {
            if (!in_array($link, $this->_js, true)) {
                $this->_js[] = $link;
            }
        }
        return $this;
    }

    public function compile(): self
    {

        return $this;
    }

    public function compileCss(): self
    {
        $minifier = new Minify\CSS($sourcePath);
        return $this;
    }
}