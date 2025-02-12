<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('feed_imports')) { // Check if table exists
            Schema::create('feed_imports', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('source');
                $table->string('type');
                $table->string('frequency')->default('daily');
                $table->timestamp('last_fetched_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('feed_imports');
    }
};
