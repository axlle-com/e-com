<?php

namespace App\Common\Assets;

use App\Common\Models\Main\BaseComponent;
use MatthiasMullie\Minify;

class Resource extends BaseComponent
{
    private array $_css;
    private array $_js;
    private array $_asset;
    private string $resourcesAssetsPath;

    public function addAssets(Asset $asset): self
    {
        $this->_asset[] = $asset;

        return $this;
    }

    public function addCss(array $css): self
    {
        foreach($css as $link) {
            if( !in_array($link, $this->_css, true)) {
                $this->_css[] = $link;
            }
        }

        return $this;
    }

    public function addJs(array $js): self
    {
        foreach($js as $link) {
            if( !in_array($link, $this->_js, true)) {
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
