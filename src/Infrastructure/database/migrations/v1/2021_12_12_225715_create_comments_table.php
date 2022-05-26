<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
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
