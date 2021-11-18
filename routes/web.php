<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');

// Redis test
Route::get('/redis', function () {
    $visits = Redis::incr('visits');
    return $visits;
});
