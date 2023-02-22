<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('question');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('term_id');
            $table->unsignedBigInteger('video_part_id')->nullable();
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->unsignedBigInteger('subject_class_id')->nullable();
            $table->timestamps();
            $table->foreign('season_id')->references('id')->on('seasons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('video_part_id')->references('id')->on('video_parts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('questions');
    }
}
