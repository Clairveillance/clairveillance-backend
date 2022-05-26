<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('emailables', function (Blueprint $table) {
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
