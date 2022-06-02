<?php

declare(strict_types=1);

use App\Application;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);
$app->useAppPath('src/App');

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Core\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    // NOTE: This is where we bind custom Exceptions Handler.
    // FIXME: Unfortunately it doesn't work when we run migrations.
    // App\Exceptions\Contracts\HandlerInterface::class,
    App\Exceptions\AppDebugHandler::class //IMPORTANT: Only for debugging!!!
    // App\Exceptions\CustomHandler::class //IMPORTANT: Turn this on when on production!!!
);

return $app;
