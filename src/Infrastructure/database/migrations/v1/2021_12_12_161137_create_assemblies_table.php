<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assemblies', function ($table) {
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
            $table->foreignUuid('assembly_type_uuid')->constrained('assembly_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assemblies');
    }
};
