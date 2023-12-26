<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exe_questions', function (Blueprint $table) {
            $table->id();

            $table->text('exercise_question');

            $table->enum('question_type', [
                'multiple choice',
                'graphic choice',
                'fill in the blanks',
                'drag and drop'
            ])->nullable();

            $table->enum('learning_tools', [
                'selection',
                'pencil',
                'calculator',
                'white board'
            ])->nullable();

            $table->string('question_graphics')->nullable();

            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exe_questions');
    }
};
