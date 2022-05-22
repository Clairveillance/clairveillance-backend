<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Resources\UserCollection;
use App\Models\User\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request): UserCollection
    {
        // NOTE: Used to debug the time of execution of a script.
        // $time_start = microtime(true);
        $users = new UserCollection(
            resource: User::with(
                relations: [
                    'profile',
                    'posts',
                    'userAssemblies',
                    'userAssembliesWithProfile'
                ]
            )
                // ->withCount(
                //     'posts'
                // )
                // ->withTrashed()
                // ->onlyTrashed()
                ->orderBy('username')
                ->paginate(25)
        );
        $users::$wrap = 'data';
        /*
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        dump(round((($time) * 1000), 2) . "ms");
        */
        return $users;
    }
}
