<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('online_exam_id')->nullable();
            $table->unsignedBigInteger('all_exam_id')->nullable();
            $table->unsignedBigInteger('life_exam_id')->nullable();

            $table->enum('type',['text','choice']);
            $table->integer('degree');
            $table->enum('status',['completed','not_completed']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('online_exam_id')->references('id')->on('online_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('all_exam_id')->references('id')->on('all_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('life_exam_id')->references('id')->on('life_exams')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degrees');
    }
}
