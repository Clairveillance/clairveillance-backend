<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('languages', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique();
            $table->string('tag')->unique(); // i.e. 'en_US'
            $table->string('code')->unique(); //i.e. 'en'
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
