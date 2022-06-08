<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_dislike');
            $table->timestampsTz();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('like_type_uuid')->constrained('like_types', 'uuid')->cascadeOnUpdate();
            $table->uuid('likeable_uuid');
            $table->string('likeable_type');
            $table->unique(['likeable_type', 'likeable_uuid', 'user_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
