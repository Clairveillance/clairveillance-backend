<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('establishables', function (Blueprint $table) {
            $table->unsignedBigInteger("establishment_id");
            $table->unsignedBigInteger("establishable_id");
            $table->string("establishable_type", 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishables');
    }
};
