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
        Schema::create('quick_insights', function (Blueprint $table) {
            $table->id();
            $table->string('importance'); // New column for importance
            $table->text('message');      // New column for message
            $table->timestamp('timestamp'); // New column for timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_insights');
    }
};
