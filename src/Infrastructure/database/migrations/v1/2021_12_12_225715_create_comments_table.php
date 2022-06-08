<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('message')->nullable();
            $table->boolean('published')->default(false);
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->uuid('commentable_uuid');
            $table->string('commentable_type');
            $table->unique(['commentable_type', 'commentable_uuid', 'user_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
