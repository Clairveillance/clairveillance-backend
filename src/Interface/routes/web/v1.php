<?php

declare(strict_types=1);

namespace Interface\routes\web;

use App\Redis\Redis;
use Illuminate\Support\Facades\Route;

// Ip address.
Route::get(uri: '/ip', action: function () {
    return 'remote address = ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL . 'browser = ' . $_SERVER['HTTP_USER_AGENT'];
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

        return Redis::test(
            connection: Redis::connect(name: $name),
            name: $name
        );
    });
}

// FIXME
// Redislabs.
Route::get(uri: '/redislabs', action: function () {
    $name = 'redislabs';

    return Redis::test(
        connection: Redis::connect(name: $name),
        name: $name
    );
});

// Upstash.
Route::get(uri: '/upstash', action: function () {
    $name = 'upstash';

    return Redis::test(
        connection: Redis::connect(name: $name),
        name: $name
    );
});

// Route::get('/{any?}') must be declared last or it will overwrite all other route methods.
Route::get(uri: '/{any?}', action: function () {
    // NOTE: We return a Forbidden response  with status code 403.
    return response(
        content: 'Forbidden',
        status: 403
    );
})->where(name: 'any', expression: '.*');
