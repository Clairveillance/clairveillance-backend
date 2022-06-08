<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sequenceables', function ($table) {
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
