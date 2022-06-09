<?php

declare(strict_types=1);

namespace App;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    /** @var string */
    public const API_PATH =
    'src' . DIRECTORY_SEPARATOR .
        'Interface' . DIRECTORY_SEPARATOR .
        'routes' . DIRECTORY_SEPARATOR .
        'api' . DIRECTORY_SEPARATOR;

    /** @var string */
    public const WEB_PATH =
    'src' . DIRECTORY_SEPARATOR .
        'Interface' . DIRECTORY_SEPARATOR .
        'routes' . DIRECTORY_SEPARATOR .
        'web' . DIRECTORY_SEPARATOR;

    /** @var string */
    protected $namespace = 'App\\';

    /**
     * @param  string $path
     * @return string
     */
    public function path($path = ''): string
    {
        return $this->buildPath(
            $this->basePath,
            'src',
            'App',
        );
    }

    /**
     * @param  string $path
     * @return string
     */
    public function configPath($path = ''): string
    {
        return $this->buildPath(
            $this->basePath,
            'src',
            'Interface',
            'config',
        );
    }

    /**
     * @param  string $path
     * @return string
     */
    public function databasePath($path = ''): string
    {
        return $this->buildPath(
            $this->basePath,
            'src',
            'Infrastructure',
            'Database',
        );
    }

    /**
     * @return string
     */
    public function publicPath(): string
    {
        return $this->buildPath(
            $this->basePath,
            'src',
            'Interface',
            'public',
        );
    }

    /**
     * @return string
     */
    public function storagePath(): string
    {
        return  $this->buildPath(
            $this->basePath,
            'src',
            'Infrastructure',
            'storage',
        );
    }

    /**
     * @param  string  $path
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return  $this->buildPath(
            $this->basePath,
            'src',
            'Interface',
            'resources',
        );
    }

    /**
     * @return string
     */
    public function langPath(): string
    {
        return $this->buildPath(
            $this->basePath,
            'src',
            'Interface',
            'lang',
        );
    }

    /**
     * @param  string $segments
     * @return string
     */
    private function buildPath(string ...$segments): string
    {
        return join(
            separator: DIRECTORY_SEPARATOR,
            array: $segments
        );
    }
}
