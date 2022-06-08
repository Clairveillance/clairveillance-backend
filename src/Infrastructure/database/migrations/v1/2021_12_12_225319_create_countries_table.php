<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('countries', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('code');
            $table->string('phone_prefix');
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('image_uuid')->constrained('images', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
