<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sequences', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('note')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('sequence_type_uuid')->constrained('sequence_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sequences');
    }
};
