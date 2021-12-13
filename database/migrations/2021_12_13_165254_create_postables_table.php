<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postables', function (Blueprint $table) {
            $table->uuid('post_uuid');
            $table->uuid('postable_uuid');
            $table->string('postable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('postables');
    }
};
