<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('user_uuid');
            $table->foreign('user_uuid')->references('uuid')->on('users')->onUpdate('cascade');
            $table->uuid('email_type_uuid');
            $table->foreign('email_type_uuid')->references('uuid')->on('email_types')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
};