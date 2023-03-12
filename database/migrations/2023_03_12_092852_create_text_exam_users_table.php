<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextExamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //اجابات الاسئله المقاليه
        Schema::create('text_exam_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('online_exam_id')->nullable();
            $table->unsignedBigInteger('all_exam_id')->nullable();
            $table->longText('answer');
            $table->longText('image');
            $table->text('audio');
            $table->enum('answer_type',['text','file','audio']);
            $table->enum('status',['solved','leave','un_correct']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('all_exam_id')->references('id')->on('all_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('online_exam_id')->references('id')->on('online_exams')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_exam_users');
    }
}
