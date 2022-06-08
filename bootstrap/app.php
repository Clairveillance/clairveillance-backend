<?php

declare(strict_types=1);

use App\Application;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);
$app->useAppPath('src/App');

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Core\V1\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Interface\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    // App\Exceptions\CustomHandler::class //IMPORTANT: Turn on when in production.
    App\Exceptions\AppDebugHandler::class //IMPORTANT: Turn off when in production, Only for debugging!!!
);

return $app;
