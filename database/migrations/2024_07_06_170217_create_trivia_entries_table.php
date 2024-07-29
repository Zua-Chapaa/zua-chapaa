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
            $table->string('poll_id');
            $table->string('question');
            $table->string('question_answer');
            $table->string('choice_1')->nullable();
            $table->string('choice_2')->nullable();
            $table->string('choice_3')->nullable();
            $table->string('choice_4')->nullable();
            $table->string('answer_user_id')->nullable();
            $table->string('user_answer')->nullable();
            $table->string('is_user_correct')->default(false);
            $table->integer('time_to_answer')->nullable();
            $table->integer('session_id');
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
