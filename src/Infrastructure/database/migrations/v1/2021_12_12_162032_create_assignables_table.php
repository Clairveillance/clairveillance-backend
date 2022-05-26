<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('assignables', function (Blueprint $table) {
            $table->uuid('assignment_uuid');
            $table->uuid('assignable_uuid');
            $table->string('assignable_type', 100);
            $table->unique(['assignable_type', 'assignable_uuid', 'assignment_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignables');
    }
};
