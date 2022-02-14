<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // NOTE: 'zip' is not an integer to prevent errors (i.e. using 'en_US' locale).
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('avatar')->nullable();
            $table->text('description')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('phone')->nullable();
            $table->string('theme')->nullable();
            $table->string('language')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
