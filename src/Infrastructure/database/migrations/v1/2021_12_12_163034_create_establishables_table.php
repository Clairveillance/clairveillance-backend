<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('establishables', function (Blueprint $table) {
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
