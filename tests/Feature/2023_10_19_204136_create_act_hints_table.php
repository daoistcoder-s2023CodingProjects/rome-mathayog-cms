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
        Schema::create('act_hints', function (Blueprint $table) {
            $table->id();
            $table->string('first_hint');
            $table->string('second_hint')->nullable();
            $table->string('third_hint')->nullable();
            $table->string('technical_hint')->nullable();
            $table->string('growth_mindset_hint')->nullable();

            $table->unsignedBigInteger('act_question_id')->nullable();
            $table->foreign('act_question_id')
                ->references('id')
                ->on('act_questions')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('act_hints');
    }
};
