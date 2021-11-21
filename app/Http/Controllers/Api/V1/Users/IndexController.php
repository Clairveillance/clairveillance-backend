<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use Domain\User\Models\User;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request): UserCollection
    {
        // NOTE: Used to debug the time of execution of a script.
        // $time_start = microtime(true);

        $users = new UserCollection(
            resource: User::orderByUsername()->paginate(20)
        );

        /*
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        dump(round((($time) * 1000), 2) . "ms");
        */

        return $users;
    }
}
