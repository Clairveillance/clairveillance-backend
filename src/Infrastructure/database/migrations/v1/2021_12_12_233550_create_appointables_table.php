<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointables', function (Blueprint $table) {
            $table->uuid('appointment_uuid');
            $table->uuid('appointable_uuid');
            $table->string('appointable_type', 100);
            $table->unique(['appointable_type', 'appointable_uuid', 'appointment_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointables');
    }
};
