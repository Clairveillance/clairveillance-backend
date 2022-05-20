<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestampsTz();
            $table->timestampTz('email_verified_at')->nullable();
            $table->softDeletes();
            $table->foreignUuid('theme_uuid')->nullable()->constrained('themes', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('language_uuid')->nullable()->constrained('languages', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('timezone_uuid')->nullable()->constrained('timezones', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
