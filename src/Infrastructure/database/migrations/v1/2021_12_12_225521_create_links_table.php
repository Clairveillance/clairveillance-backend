<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('links', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('value');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('note')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('link_type_uuid')->constrained('link_types', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('image_uuid')->nullable()->constrained('images', 'uuid')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
};
