<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->longText('body');
            $table->boolean('published')->default(false);
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('post_type_uuid')->constrained('post_types', 'uuid')->cascadeOnUpdate();
            $table->uuid('postable_uuid');
            $table->string('postable_type');
            $table->unique(['postable_type', 'postable_uuid', 'uuid'], 'polymorphic_unique');
            $table->foreignUuid('image_uuid')->nullable()->constrained('images', 'uuid')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
