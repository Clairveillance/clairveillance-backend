<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Repositories\UserRepository;
use Domain\Core\V1\Repositories\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];
}
