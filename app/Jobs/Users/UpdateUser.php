<?php

namespace App\Jobs\Users;

use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Domain\User\ValueObjects\UserValueObject;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateUser implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(
        public int $userId,
        public UserValueObject $object,
    ) {
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        $user->update($this->object->toArray());
    }
}
