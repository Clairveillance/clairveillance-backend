<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->timestampTz('start_at');
            $table->timestampTz('end_at')->nullable();
            $table->text('note')->nullable();
            $table->boolean('published')->default(false);
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('appointment_type_uuid')->constrained('appointment_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
