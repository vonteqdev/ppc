<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ppc_attributions', function (Blueprint $table) {
            $table->id();
            $table->string('conversion_id')->unique();
            $table->string('platform'); // Google, Meta, TikTok, GA4
            $table->string('campaign_name');
            $table->string('ad_name');
            $table->string('attribution_model'); // First-Click, Last-Click, Data-Driven
            $table->decimal('revenue', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('impressions')->nullable();
            $table->dateTime('conversion_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppc_attributions');
    }
};
