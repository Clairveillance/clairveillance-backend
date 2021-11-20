<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Users\IndexController;
use App\Http\Controllers\Api\V1\Users\ShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('users')->as('users.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
});

Route::prefix('user')->as('user.')->group(function () {
    Route::get('/{id}', ShowController::class)->name('show');
});
