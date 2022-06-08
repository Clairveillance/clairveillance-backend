<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignables', function ($table) {
            $table->uuid('assignment_uuid');
            $table->uuid('assignable_uuid');
            $table->string('assignable_type', 100);
            $table->unique(['assignable_type', 'assignable_uuid', 'assignment_uuid'], 'polymorphic_unique');
            $table->boolean('has_profile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignables');
    }
};
