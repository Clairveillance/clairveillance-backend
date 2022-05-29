<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('profile_type_uuid')->constrained('profile_types', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('image_uuid')->nullable()->constrained('images', 'uuid')->cascadeOnUpdate()->nullOnDelete();
            $table->uuid('profilable_uuid')->unique();
            $table->string('profilable_type');
            $table->unique(['profilable_type', 'profilable_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
