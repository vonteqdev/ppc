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
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppc_attribution');
    }
};
