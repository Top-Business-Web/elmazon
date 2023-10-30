<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestYourSelfExamQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_your_self_exam_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('test_yourself_exams')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('question_id')->references('id')->on('questions')
                ->cascadeOnUpdate()->cascadeOnDelete();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_your_self_exam_questions');
    }
}
