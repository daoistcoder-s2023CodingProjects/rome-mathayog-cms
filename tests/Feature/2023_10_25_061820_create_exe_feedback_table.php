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
        Schema::create('exe_feedback', function (Blueprint $table) {
            $table->id();
            $table->text('exercise_feedback');

            $table->unsignedBigInteger('exe_choice_id')->nullable();
            $table->foreign('exe_choice_id')
                ->references('id')
                ->on('exe_choices')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exe_feedback');
    }
};
