<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->integer('orders')->default(0);
            $table->integer('clicks')->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->decimal('cost_google', 12, 2)->default(0);
            $table->decimal('cost_facebook', 12, 2)->default(0);
            $table->decimal('wasted_money', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->decimal('roas', 12, 2)->nullable();
            $table->decimal('google_roas', 12, 2)->nullable();
            $table->string('promotion_level')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
