<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('imageables', function (Blueprint $table) {
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
