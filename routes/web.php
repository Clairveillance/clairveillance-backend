<?php

declare(strict_types=1);

use App\Redis\Redis;
use Illuminate\Support\Facades\Route;

// NOTE: PHP Info.
Route::get('/info', function () {
    return phpinfo();
});

// NOTE: Redis connection and testing.
Route::get('/redis', function () {
    // We need to call Redis::connect() from Redis\Redis to be able to use the custom connection that is specified in Environment variables config file.
    $redis = Redis::connect();
    // After that we can use any allowed method defined in the default Redis class (Illuminate\Support\Facades\Redis).
    $visits = (int) $redis->incr('visits');
    return $visits;
});

// Route::get('/{any?}') must be declared last or it will overwrite all other route methods.
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
