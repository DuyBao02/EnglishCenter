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
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->string('course_id',10);
            $table->unsignedBigInteger('lesson_id');
        
            $table->foreign('course_id')->references('id_course')->on('courses')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id_lesson')->on('lessons')->onDelete('cascade');
        
            $table->primary(['course_id', 'lesson_id']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lesson');
    }
};
