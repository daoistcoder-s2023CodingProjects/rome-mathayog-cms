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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_title', 100);
            $table->text('objective');

            $table->enum('solo_framework', [
                'Pre-Stractural',
                'Uni-Stractural',
                'Multi-Stractural',
                'Relational',
                'Extended-Abstract'
            ])->nullable();

            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
