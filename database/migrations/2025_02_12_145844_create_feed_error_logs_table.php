<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('feed_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('feed_name');
            $table->text('error_message');
            $table->timestamp('logged_at')->default(now());
            $table->timestamps(); // ✅ This adds created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('feed_error_logs');
    }
};
