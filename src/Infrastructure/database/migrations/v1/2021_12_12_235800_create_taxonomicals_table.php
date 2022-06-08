<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taxonomicals', function ($table) {
            $table->uuid('taxonomy_uuid');
            $table->uuid('taxonomical_uuid');
            $table->string('taxonomical_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomicals');
    }
};
