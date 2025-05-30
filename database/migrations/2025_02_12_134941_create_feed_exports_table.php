<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('feed_exports')) { // Check if the table exists
            Schema::create('feed_exports', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('platform');
                $table->string('export_url');
                $table->json('columns');
                $table->json('filters')->nullable();
                $table->json('label_filters')->nullable(); // Filter feeds by specific labels (e.g., "High Revenue", "Trending")

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::table('feed_exports', function (Blueprint $table) {
            $table->dropColumn('label_filters');
        });
    }
};


