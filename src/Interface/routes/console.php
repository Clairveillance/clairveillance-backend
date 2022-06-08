<?php

declare(strict_types=1);

namespace Interface\routes;

use Interface\Foundation\Inspiring;
use Interface\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
