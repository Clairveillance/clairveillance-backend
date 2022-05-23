<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sequenceables', function (Blueprint $table) {
            $table->uuid('sequence_uuid');
            $table->uuid('sequenceable_uuid');
            $table->string('sequenceable_type', 100);
            $table->unique(['sequenceable_type', 'sequenceable_uuid', 'sequence_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sequenceables');
    }
};
