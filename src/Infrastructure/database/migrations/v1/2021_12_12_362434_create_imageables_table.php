<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('imageables', function ($table) {
            $table->uuid('image_uuid');
            $table->uuid('imageable_uuid');
            $table->string('imageable_type', 100);
            $table->unique(['imageable_type', 'imageable_uuid', 'image_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('imageables');
    }
};
