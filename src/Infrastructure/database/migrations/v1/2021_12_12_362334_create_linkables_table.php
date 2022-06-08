<?php

declare(strict_types=1);

use Interface\Support\Facades\Schema;
use Interface\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('linkables', function ($table) {
            $table->uuid('link_uuid');
            $table->uuid('linkable_uuid');
            $table->string('linkable_type', 100);
            $table->unique(['linkable_type', 'linkable_uuid', 'link_uuid'], 'polymorphic_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('linkables');
    }
};
