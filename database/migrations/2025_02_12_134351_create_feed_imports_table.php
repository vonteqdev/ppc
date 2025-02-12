<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('feed_imports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('source'); // URL or File Path
            $table->enum('type', ['xml', 'csv', 'json']);
            $table->enum('frequency', ['hourly', 'daily', 'weekly'])->default('daily');
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamps();
        });

        Schema::create('feed_exports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('platform'); // google, facebook, tiktok, custom
            $table->string('export_url');
            $table->json('columns')->nullable(); // Custom fields
            $table->json('filters')->nullable(); // Filters applied
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feed_imports');
        Schema::dropIfExists('feed_exports');
    }
};
