<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Users\DeleteController;
use App\Http\Controllers\Api\V1\Users\IndexController;
use App\Http\Controllers\Api\V1\Users\ShowController;
use App\Http\Controllers\Api\V1\Users\StoreController;
use App\Http\Controllers\Api\V1\Users\UpdateController;
use Illuminate\Support\Facades\Route;

/*
 * User Endpoints.
 */

Route::prefix('users')->as('users.')->group(function () {
    Route::get(uri: '/', action: IndexController::class)->name(name: 'index');
    Route::post(uri: '/', action: StoreController::class)->name(name: 'store');
    Route::get(uri: '{uuid}', action: ShowController::class)->name(name: 'show');
    Route::patch(uri: '{user:uuid}', action: UpdateController::class)->name(name: 'update');
    Route::delete(uri: '{user:uuid}', action: DeleteController::class)->name(name: 'delete');
});
