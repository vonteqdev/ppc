<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ppc_attribution', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Google, Meta, TikTok
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('revenue', 10, 2)->default(0);
            $table->decimal('roas', 8, 2)->default(0);
            $table->decimal('google_roas', 8, 2)->nullable();
            $table->decimal('meta_roas', 8, 2)->nullable();
            $table->decimal('tiktok_roas', 8, 2)->nullable();
            $table->decimal('total_roas', 8, 2)->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('ppc_attributions', function (Blueprint $table) {
            $table->dropColumn(['google_roas', 'meta_roas', 'tiktok_roas', 'total_roas']);
        });
    }
};
