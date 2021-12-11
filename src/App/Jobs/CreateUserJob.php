<?php

declare(strict_types=1);

namespace App\Jobs;

use Domain\User\Actions\CreateUserAction;
use Domain\User\ValueObjects\UserValueObject;
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

    public function __construct(
        public UserValueObject $object,
    ) {
    }

    public function handle(): void
    {
        CreateUserAction::handle(
            object: $this->object,
        );
    }
}
