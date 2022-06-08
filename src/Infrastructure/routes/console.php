<?php

declare(strict_types=1);

use App\Foundation\Inspiring;
use App\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
