<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_instructions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('instruction');
            $table->integer('trying_number');
            $table->integer('number_of_question');
            $table->string('quiz_minute');
            $table->unsignedBigInteger('video_part_id')->nullable();
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->unsignedBigInteger('all_exam_id')->nullable();
            $table->unsignedBigInteger('subject_class_id')->nullable();
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('video_part_id')->references('id')->on('video_parts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('all_exam_id')->references('id')->on('all_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('subject_class_id')->references('id')->on('subject_classes')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_instructions');
    }
}
