<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_instructions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('instruction');
            $table->integer('trying_number');
            $table->integer('number_of_question');
            $table->string('quiz_minute');
            $table->unsignedBigInteger('all_exam_id')->nullable();
            $table->unsignedBigInteger('online_exam_id')->nullable();
            $table->foreign('all_exams')->references('id')->on('all_exam_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('online_exam_id')->references('id')->on('online_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_instructions');
    }
}
