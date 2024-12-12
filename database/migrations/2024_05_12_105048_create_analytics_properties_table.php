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
        Schema::create('google_analytics_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('google_analytics_account_id');
            $table->foreign('google_analytics_account_id')->references('id')->on('google_analytics_accounts')->onDelete('cascade');
            $table->string('property_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_analytics_properties');
    }
};
