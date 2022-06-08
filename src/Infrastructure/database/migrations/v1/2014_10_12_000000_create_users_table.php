<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function ($table): void {
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
