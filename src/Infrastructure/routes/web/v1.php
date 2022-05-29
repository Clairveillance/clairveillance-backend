<?php

declare(strict_types=1);

use App\Redis\Redis;
use Illuminate\Support\Facades\Route;

// Ip address.
Route::get(uri: '/ip', action: function () {
    return 'remote address = '.$_SERVER['REMOTE_ADDR'].PHP_EOL.'browser = '.$_SERVER['HTTP_USER_AGENT'];
});

// PHP Info.
Route::get(uri: '/info', action: function () {
    return phpinfo(flags: INFO_ALL);
});

// We need to call Redis::connect() from Redis\Redis to be able to use the custom connection that is specified in Environment variables config file.
// After that we can use any allowed method defined in the default Redis class (Illuminate\Support\Facades\Redis).

// Redis.
if (config(key: 'app.env') === 'local') {
    Route::get(uri: '/redis', action: function () {
        $name = 'localhost';
        $redis = Redis::connect(name: $name);

        return Redis::test(connection: $redis, name: $name);
    });
}

// Redislabs.
Route::get(uri: '/redislabs', action: function () {
    $name = 'redislabs';
    $redis = Redis::connect(name: $name);

    return Redis::test(connection: $redis, name: $name);
});

// Upstash.
Route::get(uri: '/upstash', action: function () {
    $name = 'upstash';
    $redis = Redis::connect(name: $name);

    return Redis::test(connection: $redis, name: $name);
});

// Route::get('/{any?}') must be declared last or it will overwrite all other route methods.
Route::get(uri: '/{any?}', action: function () {
    return view(view: 'welcome');
})->where(name: 'any', expression: '.*');
