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
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id_course', 10)->primary()->unique();
            $table->date('time_start');
            $table->string('name_course', 50);
            $table->unsignedSmallInteger('weeks');
            $table->json('days');
            $table->json('lessons');
            $table->json('rooms');
            $table->unsignedSmallInteger('maxStudents');
            $table->float('tuitionFee', 8, 2);
            $table->string('teacher', 50)->nullable();
            $table->json('students_list')->nullable();
        
            $table->unsignedBigInteger('user_id_create');
            $table->foreign('user_id_create')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
