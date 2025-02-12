<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('product_labels')) {  // ✅ Check if table exists
            Schema::create('product_labels', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->string('label'); // Hero, Villain, Zombie, Sidekick
                $table->decimal('roas', 8, 2)->nullable();
                $table->decimal('conversion_rate', 8, 2)->nullable();
                $table->integer('clicks')->nullable();
                $table->integer('impressions')->nullable();
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_labels');
    }
};

