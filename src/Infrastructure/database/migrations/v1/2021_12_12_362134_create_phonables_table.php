<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phonables', function ($table) {
            $table->uuid('phone_uuid');
            $table->uuid('phonable_uuid');
            $table->string('phonable_type', 100);
            $table->unique(['phonable_type', 'phonable_uuid', 'phone_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phonables');
    }
};
