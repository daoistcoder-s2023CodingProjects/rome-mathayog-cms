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
        Schema::create('sum_choices', function (Blueprint $table) {
            $table->id();

            $table->string('choice_text', 100)->nullable();
            $table->string('choice_graphics')->nullable();

            $table->enum('correct', [
                'TRUE',
                'FALSE'
            ])->nullable();
            
            $table->unsignedBigInteger('sum_question_id')->nullable();
            $table->foreign('sum_question_id')
                ->references('id')
                ->on('sum_questions')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sum_choices');
    }
};
