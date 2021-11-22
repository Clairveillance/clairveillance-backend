<?php

namespace App\Jobs\Users;

use Domain\User\Models\User;
use Domain\User\ValueObjects\UserValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
