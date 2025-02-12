<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('label');
            $table->decimal('roas', 8, 2)->nullable();
            $table->decimal('conversion_rate', 8, 2)->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('impressions')->nullable();
            $table->decimal('margin', 8, 2)->nullable();
            $table->timestamps();

            // Ensure products table exists before adding foreign key
            if (Schema::hasTable('products')) {
                $table->foreign('product_id')
                      ->references('id')->on('products')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_labels', function (Blueprint $table) {
            if (Schema::hasColumn('product_labels', 'product_id')) {
                $table->dropForeign(['product_id']);
            }
        });

        Schema::dropIfExists('product_labels');
    }
};

