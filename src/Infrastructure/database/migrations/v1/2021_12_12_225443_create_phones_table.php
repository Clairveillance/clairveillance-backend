<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('value');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('note')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('phone_type_uuid')->constrained('phone_types', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('country_uuid')->constrained('countries', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phones');
    }
};
