<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emails', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('value');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('host');
            $table->string('domain');
            $table->string('note')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('email_type_uuid')->constrained('email_types', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
};
