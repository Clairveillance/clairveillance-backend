<?php

declare(strict_types=1);

use App\Core\Controllers\Api\V1\Posts\DeleteController as PostDelete;
use App\Core\Controllers\Api\V1\Posts\IndexByUserController as UserPostsIndex;
use App\Core\Controllers\Api\V1\Posts\IndexController as PostIndex;
use App\Core\Controllers\Api\V1\Posts\ShowController as PostShow;
use App\Core\Controllers\Api\V1\Posts\StoreController as PostStore;
use App\Core\Controllers\Api\V1\Posts\UpdateController as PostUpdate;
use App\Core\Controllers\Api\V1\Users\DeleteController as UserDelete;
use App\Core\Controllers\Api\V1\Users\IndexController as UserIndex;
use App\Core\Controllers\Api\V1\Users\ShowController as UserShow;
use App\Core\Controllers\Api\V1\Users\StoreController as UserStore;
use App\Core\Controllers\Api\V1\Users\UpdateController as UserUpdate;
use App\Models\Assembly\Assembly;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
 * Users Endpoints.
 */

Route::prefix('users')->as('users.')->group(function () {
    Route::get(uri: '/', action: UserIndex::class)->name(name: 'index');
    Route::post(uri: '/', action: UserStore::class)->name(name: 'store');
    Route::get(uri: '{uuid}', action: UserShow::class)->name(name: 'show');
    Route::patch(uri: '{user:uuid}', action: UserUpdate::class)->name(name: 'update');
    Route::delete(uri: '{user:uuid}', action: UserDelete::class)->name(name: 'delete');
    Route::get(uri: '{uuid}/posts', action: UserPostsIndex::class)->name(name: 'index.posts');
});

/*
 * Posts Endpoints.
 */

Route::prefix('posts')->as('posts.')->group(function () {
    Route::get(uri: '/', action: PostIndex::class)->name(name: 'index');
    // Route::post(uri: '/', action: PostStore::class)->name(name: 'store');
    Route::get(uri: '{post:slug}', action: PostShow::class)->name(name: 'show');
    // Route::patch(uri: '{user:uuid}', action: PostUpdate::class)->name(name: 'update');
    // Route::delete(uri: '{user:uuid}', action: PostDelete::class)->name(name: 'delete');
});

/*
 * Tests Endpoints.
 */

Route::prefix('tests')->as('tests.')->group(function () {
    Route::get(uri: '/', action: function () {
        return
            response()->json(
                data: [
                    'succes' => true,
                    'status' => 200,
                    'message' => 'OK',
                    'data' => Assembly::has('likes')->with(['assemblies', 'assembliesHasProfile', 'likes'])->first(),
                ],
                status: 200
            );
    })->name(name: 'index');
});
