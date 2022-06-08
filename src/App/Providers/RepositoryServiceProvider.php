<?php

declare(strict_types=1);

namespace App\Providers;

use Domain\Core\V1\Users\Repositories\UserRepositoryInterface;
use App\Core\V1\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];
}
