<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addressables', function (Blueprint $table) {
            $table->uuid('address_uuid');
            $table->uuid('addressable_uuid');
            $table->string('addressable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('addressables');
    }
};
