<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('establishables', function ($table) {
            $table->uuid('establishment_uuid');
            $table->uuid('establishable_uuid');
            $table->string('establishable_type', 100);
            $table->unique(['establishable_type', 'establishable_uuid', 'establishment_uuid'], 'polymorphic_unique');
            $table->boolean('has_profile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishables');
    }
};
