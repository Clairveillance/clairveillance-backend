<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('linkables', function (Blueprint $table) {
            $table->uuid('link_uuid');
            $table->uuid('linkable_uuid');
            $table->string('linkable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('linkables');
    }
};
