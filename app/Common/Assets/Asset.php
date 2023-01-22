<?php

namespace App\Common\Assets;

use App\Common\Models\Main\BaseComponent;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Setting\Setting;
use Exception;
use RuntimeException;

abstract class Asset extends BaseComponent
{
    private static array $methods = [];
    public ?Resource $handler;
    public string $template = 'mimity';
    public string $client = 'backend';
    private string $path;
    private string $file = '';
    private array $css = [];
    private array $js = [];
    private array $depends = [];

    public static function register(?Asset $asset = null): static
    {
        $self = static::model();
        if ($asset) {
            $self->css[] = $asset->css;
            $self->js[] = $asset->js;
        }
        return $self;
    }

    public static function js(string $file = null): string
    {
        $self = static::model();
        $js = '';
        $file = $file ? $self->setFile($file)->file : $self->file;
        if (config('app.test')) {
            $file = $self->path . '/js/_' . $file . '.js';
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
            $common = $self->path . '/js/common.js';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $js .= '<script src="' . $common . '?v' . $time . '"></script>';
            }
        } else {
            $file = $self->path . '/js/' . $file . '.js';
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

    public static function img(string $name): string
    {
        $self = static::model();
        $ip = $_SERVER['SERVER_NAME'];
        return $ip . $self->path . '/assets/img/' . trim($name, '/');
    }

    public static function imgTag(string $name, BaseModel $baseModel = null): string
    {
        $self = static::model();
        $title = $baseModel ? ($baseModel->title_short ?? $baseModel->title ?? '') : '';
        $title .= '';
        return '<img src="' . $self->path . '/assets/img/' . trim($name, '/') . '" alt="' . $title . '"/>';
    }

    /**
     * @throws Exception
     */
    public static function __callStatic(string $method, array $parameters)
    {
        if (!array_key_exists($method, self::$methods)) {
            throw new RuntimeException('The ' . $method . ' is not supported.');
        }
        return MainAsset::model()->{self::$methods[$method]}($parameters[0]);
    }

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

    public function compile(): self
    {
        $this->handler->addCss($this->css);
        $this->handler->addJs($this->js);
        return $this;
    }

    public function head()
    {
        $path = $this->client . '.inc.head';
        $data = array_merge($this->toArray(), ['css' => $this::css()]);
        return view($path, $data);
    }

    public static function css(string $file = null): string
    {
        $self = static::model();
        $css = '';
        $file = $file ? $self->setfile($file)->file : $self->file;
        if (config('app.test')) {
            $file = $self->path . '/css/_' . $file . '.css';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $file . '?v' . $time . '">';
            }
            $common = $self->path . '/css/common.css';
            $filename = public_path($common);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $common . '?v' . $time . '">';
            }
        } else {
            $file = $self->path . '/css/' . $file . '.css';
            $filename = public_path($file);
            if (file_exists($filename)) {
                $time = filemtime($filename);
                $css .= '<link rel="stylesheet" type="text/css" href="' . $file . '?v' . $time . '">';
            }
        }
        return $css;
    }
}
