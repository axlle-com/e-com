<?php

namespace App\Common\Assets;

use App\Common\Models\Main\BaseComponent;
use App\Common\Models\Main\Setting;

abstract class Asset extends BaseComponent
{
    public ?Resource $handler;
    public string $template = '';
    public string $basePath = '@webroot';
    public string $baseUrl = '@web';
    protected array $css = [
    ];
    protected array $js = [
    ];
    protected array $depends = [
    ];

    public function init(): static
    {
        $this->template = Setting::model()->template;
        $this->handler = Resource::model();
        return $this;
    }

    public static function register(?Asset $asset = null): static
    {
        $self = static::model();
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

    public static function css(string $route): string
    {
        $css = '';
        $route = trim($route, '/');
        $template = '/frontend/' . static::model()->template;
        if (config('app.test')) {
            $route = $template . '/css/_' . $route . '.css';
            $filename = public_path($route);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $route . '?v' . $time . '">';
            }
            $common = '/frontend/css/common.css';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $common . '?v' . $time . '">';
            }
        } else {
            $route = $template . '/css/' . $route . '.css';
            $filename = public_path($route);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $route . '?v' . $time . '">';
            }
        }
        return $css;
    }

    public static function js(string $route): string
    {
        $js = '';
        $route = trim($route, '/');
        $template = '/frontend/' . static::model()->template;
        if (config('app.test')) {
            $route = $template . '/js/_' . $route . '.js';
            $filename = public_path($route);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $route . '?v' . $time . '"></script>';
            }
            $glob = '/main/js/glob.js';
            $filename = public_path($glob);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $glob . '?v' . $time . '"></script>';
            }
            $common = '/frontend/js/common.js';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $common . '?v' . $time . '"></script>';
            }
        } else {
            $route = $template . '/js/' . $route . '.js';
            $filename = public_path($route);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $route . '?v' . $time . '"></script>';
            }
        }
        return $js;
    }
}