<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('report_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('email'); // Who receives the report
            $table->enum('frequency', ['daily', 'weekly', 'monthly']); // How often
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_schedules');
    }
};

