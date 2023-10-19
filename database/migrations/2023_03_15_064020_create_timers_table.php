<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('online_exam_id')->nullable();
            $table->unsignedBigInteger('all_exam_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string("timer");
            $table->foreign('online_exam_id')->references('id')->on('online_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('all_exam_id')->references('id')->on('all_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('timers');
    }
}
