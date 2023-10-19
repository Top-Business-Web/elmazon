<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->text('answer');
            $table->string('answer_number')->nullable();
            $table->enum('answer_status',['correct','un_correct'])->default('correct')->comment('Answer status');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('question_id');
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
