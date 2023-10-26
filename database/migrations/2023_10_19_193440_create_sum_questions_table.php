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
        Schema::create('sum_questions', function (Blueprint $table) {
            $table->id();

            $table->text('summative_assesment_question');

            $table->enum('question_type', [
                'multiple choice',
                'graphic choice',
                'fill in the blanks',
                'drag and drop'
            ])->nullable();

            $table->string('question_graphics')->nullable();

            $table->unsignedBigInteger('summative_assesment_id')->nullable();
            $table->foreign('summative_assesment_id')
                ->references('id')
                ->on('summative_assesments')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sum_questions');
    }
};
