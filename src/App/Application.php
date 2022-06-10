<?php

declare(strict_types=1);

namespace App;

use App\Support\Traits\ApplicationHelpers;
use Illuminate\Foundation\Application as BaseApplication;

define('API_PATH', ApplicationHelpers::setPath('src', 'Interface', 'routes', 'api') . DIRECTORY_SEPARATOR);
define('WEB_PATH', ApplicationHelpers::setPath('src', 'Interface', 'routes', 'web') . DIRECTORY_SEPARATOR);

class Application extends BaseApplication
{
    use ApplicationHelpers;

    /** @var string */
    protected $namespace = 'App\\';

    /**
     * This is where we overwrite Laravel's default Application path.
     * 
     * @param  string $path
     * @return string
     */
    public function path($path = ''): string
    {
        return $this::setPath(
            $this->basePath,
            'src',
            'App',
        );
    }

    /**
     * This is where we overwrite Laravel's default Configuration path.
     * 
     * @param  string $path
     * @return string
     */
    public function configPath($path = ''): string
    {
        return $this::setPath(
            $this->basePath,
            'src',
            'App',
            'config',
        );
    }

    /**
     * This is where we overwrite Laravel's default Database path.
     * 
     * @param  string $path
     * @return string
     */
    public function databasePath($path = ''): string
    {
        return $this::setPath(
            $this->basePath,
            'src',
            'Infrastructure',
            'Database',
        );
    }

    /**
     * This is where we overwrite Laravel's default Public path.
     * 
     * @return string
     */
    public function publicPath(): string
    {
        return $this::setPath(
            $this->basePath,
            'src',
            'Interface',
            'public',
        );
    }

    /**
     * This is where we overwrite Laravel's default Storage path.
     * 
     * @return string
     */
    public function storagePath(): string
    {
        return  $this::setPath(
            $this->basePath,
            'src',
            'Infrastructure',
            'storage',
        );
    }

    /**
     * This is where we overwrite Laravel's default Resources path.
     * 
     * @param  string  $path
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return  $this::setPath(
            $this->basePath,
            'src',
            'Interface',
            'resources',
        );
    }

    /**
     * This is where we overwrite Laravel's default Languages path.
     * 
     * @return string
     */
    public function langPath(): string
    {
        return $this::setPath(
            $this->basePath,
            'src',
            'Interface',
            'lang',
        );
    }
}
