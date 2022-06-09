<?php

declare(strict_types=1);

namespace App;

class Application extends \Illuminate\Foundation\Application
{
    protected $namespace = 'App\\';

    public function publicPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Interface' . DIRECTORY_SEPARATOR . 'public';
    }

    public function storagePath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Infrastructure' . DIRECTORY_SEPARATOR . 'storage';
    }
}
