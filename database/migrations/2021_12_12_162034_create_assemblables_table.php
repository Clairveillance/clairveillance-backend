<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assemblables', function (Blueprint $table) {
            $table->unsignedBigInteger("assembly_id");
            $table->unsignedBigInteger("assemblable_id");
            $table->string("assemblable_type", 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assemblables');
    }
};
