<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('establishment_type_uuid');
            $table->foreign('establishment_type_uuid')->references('uuid')->on('establishment_types')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishments');
    }
};
