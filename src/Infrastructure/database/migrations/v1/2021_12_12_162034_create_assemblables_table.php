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
            $table->uuid('assembly_uuid');
            $table->uuid('assemblable_uuid');
            $table->string('assemblable_type', 100);
            $table->unique(['assemblable_type', 'assemblable_uuid', 'assembly_uuid'], 'polymorphic_unique');
            $table->boolean('has_profile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assemblables');
    }
};
