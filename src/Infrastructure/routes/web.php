<?php

declare(strict_types=1);

use App\Redis\Redis;
use Illuminate\Support\Facades\Route;

// PHP Info.
Route::get('/info', function () {
    return phpinfo();
});

// Redis.
if (config('app.env') === 'local') {
    Route::get('/redis', function () {
        $name = 'localhost';
        // We need to call Redis::connect() from Redis\Redis to be able to use the custom connection that is specified in Environment variables config file.
        // After that we can use any allowed method defined in the default Redis class (Illuminate\Support\Facades\Redis).
        $redis = Redis::connect($name);
        return Redis::test($redis);
    });
}

// Redislabs.
Route::get('/redislabs', function () {
    $name = 'redislabs';
    $redis = Redis::connect($name);
    return Redis::test($redis, $name);
});

// Upstash.
Route::get('/upstash', function () {
    $name = 'upstash';
    $redis = Redis::connect($name);
    return Redis::test($redis, $name);
});

// Route::get('/{any?}') must be declared last or it will overwrite all other route methods.
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
