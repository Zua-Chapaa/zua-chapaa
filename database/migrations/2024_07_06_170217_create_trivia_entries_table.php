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
        Schema::create('trivia_entries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('question');
            $table->string('answer');
            $table->string('set_ans');
            $table->boolean('is_user_correct');
            $table->integer('time_to_answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivia_entries');
    }
};
