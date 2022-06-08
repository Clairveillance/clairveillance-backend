<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assemblables', function ($table) {
            $table->uuid('assembly_uuid');
            $table->uuid('assemblable_uuid');
            $table->string('assemblable_type', 100);
            $table->unique(['assemblable_type', 'assemblable_uuid', 'assembly_uuid'], 'polymorphic_unique');
            $table->boolean('has_profile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assemblables');
    }
};
