<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Jobs;

use Domain\Core\V1\Users\Actions\Commands\CreateUserAction;
use Domain\Core\V1\Users\Types\Entities\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CreateUserJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(public UserEntity $object)
    {
    }

    public function handle(): void
    {
        CreateUserAction::handle(
            object: $this->object,
        );
    }
}
