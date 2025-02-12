<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('labeling_rules', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Google, Meta, TikTok
            $table->string('label'); // Hero, Villain, Zombie, Sidekick
            $table->string('metric'); // ROAS, Conversion Rate, Clicks, Impressions
            $table->string('condition'); // Greater than, Less than, Equals
            $table->decimal('value', 8, 2); // Threshold value
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('labeling_rules');
    }
};
