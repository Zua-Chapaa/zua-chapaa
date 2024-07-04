<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_group_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timestamp');
            $table->boolean('Active')->default(false);
            $table->json('LeaderBoard')->nullable();
            $table->text('comments')->nullable();
            $table->string('running_time')->nullable();
            $table->text('stats')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_group_sessions');
    }
};
