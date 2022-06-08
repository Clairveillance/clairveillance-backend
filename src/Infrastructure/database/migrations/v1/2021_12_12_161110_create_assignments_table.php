<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignments', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->nullable()->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('published')->default(false);
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('assignment_type_uuid')->constrained('assignment_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};
