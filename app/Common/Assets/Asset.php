<?php

namespace App\Common\Assets;

abstract class Asset
{
    public ?Resource $handler;
    public string $basePath = '@webroot';
    public string $baseUrl = '@web';
    public array $css = [
    ];
    public array $js = [
    ];
    public array $depends = [
    ];

    private function __construct()
    {
        $this->handler = Resource::model();
    }

    public static function register(?Asset $asset = null): static
    {
        $self = new static();
        if ($asset) {
            $self->css[] = $asset->css;
            $self->js[] = $asset->js;
        }
        return $self;
    }

    public function compile(): self
    {
        $this->handler->addCss($this->css);
        $this->handler->addJs($this->js);
        $this->handler->compile();
        return $this;
    }
}