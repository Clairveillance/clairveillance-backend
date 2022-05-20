<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('phonables', function (Blueprint $table) {
            $table->uuid('phone_uuid');
            $table->uuid('phonable_uuid');
            $table->string('phonable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('phonables');
    }
};
