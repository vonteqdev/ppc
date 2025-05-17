<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->string('metric');     // ex: engaged_sessions, non_engaged_sessions
            $table->unsignedBigInteger('value')->default(0); // valoarea metricii
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('analytics');
    }
};
