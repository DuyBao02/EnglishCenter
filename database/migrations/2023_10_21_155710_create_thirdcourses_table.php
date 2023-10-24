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
        Schema::create('thirdcourses', function (Blueprint $table) {
            $table->string('id_3course', 10)->primary();
            $table->date('time_start');
            $table->string('name_course', 50);
            $table->unsignedSmallInteger('weeks');
            $table->json('days');
            $table->json('lessons');
            $table->json('rooms');
            $table->unsignedSmallInteger('maxStudents');
            $table->double('tuitionFee', 10, 2);
            $table->string('teacher', 50)->nullable();
            $table->json('students_list')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thirdcourses');
    }
};
