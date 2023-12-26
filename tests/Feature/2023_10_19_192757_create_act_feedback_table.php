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
        Schema::create('act_feedback', function (Blueprint $table) {
            $table->id();
            $table->text('activity_feedback');
    
            $table->unsignedBigInteger('act_choice_id')->nullable();
            $table->foreign('act_choice_id')
                ->references('id')
                ->on('act_choices')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('act_feedback');
    }
};
