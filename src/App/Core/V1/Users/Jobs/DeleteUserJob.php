<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Jobs;

use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class DeleteUserJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(public int $userId)
    {
    }

    public function handle(): void
    {
        $user = User::findOrFail($this->userId);
        $user->delete();
    }
}
