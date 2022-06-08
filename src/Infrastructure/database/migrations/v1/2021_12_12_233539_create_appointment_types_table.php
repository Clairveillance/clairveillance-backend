<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointment_types', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique();
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_types');
    }
};
