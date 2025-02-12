<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ppc_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Google Ads, Meta Ads, TikTok
            $table->string('ad_name');
            $table->string('recommendation_type'); // "Increase Budget", "Pause Ad", "Adjust Targeting"
            $table->text('message'); // AI-generated insights
            $table->boolean('action_taken')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppc_recommendations');
    }
};

