<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

// Redis connection and testing.
Route::get('/redis', function () {
    $redis = Redis::connection('redislabs_cloud');
    $visits = $redis->incr('visits');
    return $visits;
});

// Must be declared last or it will overwrite all other routes.
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
