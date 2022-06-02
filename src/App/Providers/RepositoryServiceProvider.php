<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Repositories\Api\V1\Users\UserRepository;
use App\Core\Repositories\Api\V1\Users\Concerns\Contracts\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class
    ];
}
