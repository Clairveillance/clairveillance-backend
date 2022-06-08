<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointables', function ($table) {
            $table->uuid('appointment_uuid');
            $table->uuid('appointable_uuid');
            $table->string('appointable_type', 100);
            $table->unique(['appointable_type', 'appointable_uuid', 'appointment_uuid'], 'polymorphic_unique');
            $table->boolean('has_profile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointables');
    }
};
