<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Users\IndexController;
use App\Http\Controllers\Api\V1\Users\ShowController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->as('users.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::get('{user:uuid}', ShowController::class)->name('show');
});
