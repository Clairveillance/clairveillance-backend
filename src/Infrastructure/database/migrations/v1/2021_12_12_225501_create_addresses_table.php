<?php

declare(strict_types=1);

use App\Support\Facades\Schema;
use App\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        // NOTE: 'post_code' is not an integer to prevent errors (i.e. using 'en_US' locale).
        Schema::create('addresses', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('street_1');
            $table->string('street_2')->nullable();
            $table->string('street_number');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('post_code');
            $table->string('region');
            $table->string('note')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('address_type_uuid')->constrained('address_types', 'uuid')->cascadeOnUpdate();
            $table->foreignUuid('country_uuid')->constrained('countries', 'uuid')->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
