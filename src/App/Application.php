<?php

declare(strict_types=1);

namespace App;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    protected $namespace = 'App\\';

    public const API_PATH =
    'src' . DIRECTORY_SEPARATOR .
        'Interface' . DIRECTORY_SEPARATOR .
        'routes' . DIRECTORY_SEPARATOR .
        'api' . DIRECTORY_SEPARATOR;

    public const WEB_PATH =
    'src' . DIRECTORY_SEPARATOR .
        'Interface' . DIRECTORY_SEPARATOR .
        'routes' . DIRECTORY_SEPARATOR .
        'web' . DIRECTORY_SEPARATOR;

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
