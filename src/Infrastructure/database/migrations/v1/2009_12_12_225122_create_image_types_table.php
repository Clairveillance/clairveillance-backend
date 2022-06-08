<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('image_types', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique();
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_types');
    }
};
