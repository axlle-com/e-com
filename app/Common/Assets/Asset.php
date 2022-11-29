<?php

namespace App\Common\Assets;

use App\Common\Models\Main\BaseComponent;
use App\Common\Models\Main\Setting;

abstract class Asset extends BaseComponent
{
    public ?Resource $handler;
    public string $template = 'mimity';
    public string $client = 'backend';
    private string $path;
    private string $file;
    private array $css = [
    ];
    private array $js = [
    ];
    private array $depends = [
    ];

    public function init(): static
    {
        if ($this instanceof MainAsset) {
            $this->template = Setting::model()->getTemplate();
            $this->client = 'frontend';
        } else {
            $this->template = 'mimity';
        }
        $this->path = '/' . $this->client . '/' . $this->template;
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
//        $this->handler->compile();
        return $this;
    }

    public function css(string $file = null): string
    {
        $css = '';
        $file = $file ? $this->setfile($file)->file : $this->file;
        if (config('app.test')) {
            $file = $this->path . '/css/_' . $file . '.css';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $file . '?v' . $time . '">';
            }
            $common = $this->path . '/css/common.css';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $common . '?v' . $time . '">';
            }
        } else {
            $file = $this->path . '/css/' . $file . '.css';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $file . '?v' . $time . '">';
            }
        }
        return $css;
    }

    public function js(string $file = null): string
    {
        $js = '';
        $file = $file ? $this->setFile($file)->file : $this->file;
        if (config('app.test')) {
            $file = $this->path . '/js/_' . $file . '.js';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $file . '?v' . $time . '"></script>';
            }
            $glob = '/main/js/glob.js';
            $filename = public_path($glob);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $glob . '?v' . $time . '"></script>';
            }
            $common = $this->path . '/js/common.js';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $common . '?v' . $time . '"></script>';
            }
        } else {
            $file = $this->path . '/js/' . $file . '.js';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $file . '?v' . $time . '"></script>';
            }
        }
        return $js;
    }

    public function setFile(string $file): static
    {
        $this->file = trim($file, '/');
        return $this;
    }

    public function head()
    {
        $path = $this->client . '.inc.head';
        $data = array_merge($this->toArray(), ['css' => $this->css()]);
        return view($path, $data);
    }
}