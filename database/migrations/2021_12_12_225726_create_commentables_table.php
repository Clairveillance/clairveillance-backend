<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commentables', function (Blueprint $table) {
            $table->uuid('comment_uuid');
            $table->uuid('commentable_uuid');
            $table->string('commentable_type', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentables');
    }
};
