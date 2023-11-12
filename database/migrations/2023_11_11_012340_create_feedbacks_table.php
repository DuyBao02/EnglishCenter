<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->text('comment_content');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->timestamp('datesend')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
