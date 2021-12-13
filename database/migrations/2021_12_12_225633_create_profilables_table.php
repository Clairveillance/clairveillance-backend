<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profilables', function (Blueprint $table) {
            $table->uuid('profile_uuid');
            $table->uuid('profilable_uuid');
            $table->string('profilable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('profilables');
    }
};
