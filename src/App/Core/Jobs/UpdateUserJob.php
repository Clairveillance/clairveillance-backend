<?php

declare(strict_types=1);

namespace App\Core\Jobs;

use App\Models\User\User;
use Domain\User\ValueObjects\UserValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class UpdateUserJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(public int $userId, public UserValueObject $object)
    {
    }

    public function handle(): void
    {
        $user = User::findOrFail($this->userId);
        $user->update($this->object->toArray());
    }
}
