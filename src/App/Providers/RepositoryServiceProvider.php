<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Repositories\Api\Contracts\UserRepositoryInterface;
use App\Core\Repositories\Api\V1\Users\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];
}
