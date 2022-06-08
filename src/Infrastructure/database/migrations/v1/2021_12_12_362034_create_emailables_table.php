<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emailables', function ($table) {
            $table->uuid('email_uuid');
            $table->uuid('emailable_uuid');
            $table->string('emailable_type', 100);
            $table->unique(['emailable_type', 'emailable_uuid', 'email_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emailables');
    }
};
