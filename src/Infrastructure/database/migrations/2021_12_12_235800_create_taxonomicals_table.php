<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('taxonomicals', function (Blueprint $table) {
            $table->uuid('taxonomy_uuid');
            $table->uuid('taxonomical_uuid');
            $table->string('taxonomical_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomicals');
    }
};
