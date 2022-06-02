<?php

declare(strict_types=1);

namespace App\Providers;

use App\Exceptions\Handler;
use App\Exceptions\CustomHandler;
use App\Exceptions\AppDebugHandler;
use Illuminate\Support\ServiceProvider;
use App\Exceptions\Contracts\HandlerInterface;

class ExceptionsHandlerServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public array $bindings = [
        // HandlerInterface::class => Handler::class
    ];

    // NOTE: We bind custom Handlers depending on the Debug mode that we have defined in our environment file.
    public function register()
    {
        match (config('app.debug')) {
            true => $this->bindings = [HandlerInterface::class => AppDebugHandler::class], // IMPORTANT: Used for debug only !!!
            false => $this->bindings = [HandlerInterface::class => CustomHandler::class],
            default => [HandlerInterface::class => CustomHandler::class]
        };
    }
}
