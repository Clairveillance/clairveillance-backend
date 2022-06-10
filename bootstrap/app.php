<?php

declare(strict_types=1);

use App\Application;
use DevCoder\DotEnv;

/** Bootstrap Laravel's Application */
$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

(new DotEnv(dirname(__DIR__) . '/.env'))->load();

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Core\V1\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Interface\Console\Kernel::class
);

match (env('APP_DEBUG')) {
    true => $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\AppDebugHandler::class
    ),
    default => $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\CustomHandler::class
    ),
};
return $app;
