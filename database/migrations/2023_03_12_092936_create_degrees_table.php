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
            $table->unsignedBigInteger('text_exam_user_id')->nullable();
            $table->unsignedBigInteger('online_exam__user_id')->nullable();
            $table->enum('type',['text','choice']);
            $table->integer('degree');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('text_exam_user_id')->references('id')->on('text_exam_users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('online_exam__user_id')->references('id')->on('online_exam__users')->cascadeOnUpdate()->cascadeOnDelete();
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
