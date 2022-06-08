<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taxonomies', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('taxonomy_type_uuid')->constrained('taxonomy_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomies');
    }
};
