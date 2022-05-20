<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_dislike');
            $table->timestampsTz();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('like_type_uuid')->constrained('like_types', 'uuid')->cascadeOnUpdate();
            $table->uuid('likeable_uuid')->unique();
            $table->string('likeable_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
